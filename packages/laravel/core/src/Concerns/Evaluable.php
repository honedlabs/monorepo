<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use BackedEnum;
use Closure;
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
     * The identifier to use for evaluation.
     *
     * @var string|null
     */
    protected $evaluationIdentifier;

    /**
     * Evaluate an expression with correct dependencies.
     *
     * @template T
     *
     * @param  T|(callable(mixed...):T|null)|null  $value
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     * @return T|null
     *
     * @throws BindingResolutionException
     */
    public function evaluate(mixed $value, array $named = [], array $typed = []): mixed
    {
        if (is_object($value) && method_exists($value, '__invoke')) {
            $value = $value->__invoke(...); // @phpstan-ignore-line
        }

        if (! $value instanceof Closure) {
            /** @var T */
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
     * @param  array<string,mixed>  $named
     * @param  array<string,mixed>  $typed
     */
    protected function resolveClosureDependencyForEvaluation(ReflectionParameter $parameter, array $named = [], array $typed = []): mixed
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

        if (
            (
                isset($this->evaluationIdentifier) &&
                ($parameterName === $this->evaluationIdentifier)
            ) ||
            ($typedParameterClassName === static::class)
        ) {
            return $this;
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
     */
    protected function getTypedReflectionParameterClassName(ReflectionParameter $parameter): ?string
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
     * @return array<int,mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return [];
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     *
     * @return array<int,mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        return [App::make($parameterType)];
    }
}
