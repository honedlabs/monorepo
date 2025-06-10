<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use BackedEnum;
use Closure;
use Honed\Core\Primitive;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\App;
use ReflectionFunction;
use ReflectionNamedType;
use ReflectionParameter;

use function array_key_exists;
use function count;
use function is_object;

/**
 * @phpstan-require-extends \Honed\Core\Primitive
 */
trait Evaluable
{
    /**
     * Evaluate an expression with correct dependencies.
     *
     * @param  mixed  $value
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     * @return mixed
     */
    public function evaluate($value, $named = [], $typed = [])
    {
        if (is_object($value) && method_exists($value, '__invoke')) {
            $value = $value->__invoke(...); // @phpstan-ignore-line
        }

        if (! $value instanceof Closure) {
            return $value instanceof BackedEnum ? $value->value : $value;
        }

        $dependencies = [];

        foreach ((new ReflectionFunction($value))->getParameters() as $parameter) {
            $dependencies[] = $this->resolveClosureDependencyForEvaluation($parameter, $named, $typed);
        }

        return $value(...$dependencies);
    }

    /**
     * Resolve a closure dependency for evaluation.
     *
     * @param  ReflectionParameter  $parameter
     * @param  array<string,mixed>  $named
     * @param  array<string,mixed>  $typed
     * @return mixed
     */
    protected function resolveClosureDependencyForEvaluation($parameter, $named = [], $typed = [])
    {
        $parameterName = $parameter->getName();

        if (array_key_exists($parameterName, $named)) {
            return value($named[$parameterName]);
        }

        $typedParameterClassName = $this->getTypedReflectionParameterClassName($parameter);

        if (filled($typedParameterClassName) && array_key_exists($typedParameterClassName, $typed)) {
            return value($typed[$typedParameterClassName]);
        }

        // Dependencies are wrapped in an array to differentiate between null and no value.
        $defaultWrappedDependencyByName = $this->resolveDefaultClosureDependencyForEvaluationByName($parameterName);

        if (count($defaultWrappedDependencyByName)) {
            // Unwrap the dependency if it was resolved.
            return $defaultWrappedDependencyByName[0];
        }

        if (filled($typedParameterClassName)) {
            // Dependencies are wrapped in an array to differentiate between null and no value.
            $defaultWrappedDependencyByType = $this->resolveDefaultClosureDependencyForEvaluationByType($typedParameterClassName);

            if (count($defaultWrappedDependencyByType)) {
                // Unwrap the dependency if it was resolved.
                return $defaultWrappedDependencyByType[0];
            }
        }

        if (filled($typedParameterClassName)) {
            return app()->make($typedParameterClassName);
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        if ($parameter->isOptional()) {
            return null;
        }

        $staticClass = static::class;

        throw new BindingResolutionException("An attempt was made to evaluate a closure for [{$staticClass}], but [\${$parameterName}] was unresolvable.");
    }

    /**
     * Retrieve the typed reflection parameter class name.
     *
     * @param  ReflectionParameter  $parameter
     * @return string|null
     */
    protected function getTypedReflectionParameterClassName($parameter)
    {
        $type = $parameter->getType();

        if (! $type instanceof ReflectionNamedType) {
            return null;
        }

        if ($type->isBuiltin()) {
            return null;
        }

        $name = $type->getName();

        $class = $parameter->getDeclaringClass();

        if (blank($class)) {
            return $name;
        }

        if ($name === 'self') {
            return $class->getName();
        }

        if ($name === 'parent' && ($parent = $class->getParentClass())) {
            return $parent->getName();
        }

        return $name;
    }

    /**
     * Provide a selection of default dependencies for evaluation by name.
     *
     * @param  string  $parameterName
     * @return array<int,mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        return match ($parameterName) {
            'primitive', 'self' => [$this],
            default => []
        };
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     *
     * @param  string  $parameterType
     * @return array<int,mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        return match ($parameterType) {
            Primitive::class, static::class => [$this],
            default => [App::make($parameterType)],
        };
    }
}
