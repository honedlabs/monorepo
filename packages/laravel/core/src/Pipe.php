<?php

declare(strict_types=1);

namespace Honed\Core;

use Closure;
use Illuminate\Support\Facades\App;
use ReflectionMethod;
use ReflectionNamedType;

/**
 * @template T of Primitive
 *
 * @method void run(mixed ...$arguments)
 */
abstract class Pipe
{
    /**
     * Apply the pipe.
     */
    public function handle(Primitive $primitive, Closure $next): Primitive
    {
        App::call([$this, 'run'], $this->getParameters($primitive));

        return $next($primitive);
    }

    /**
     * Get the parameters for the pipe.
     *
     * @return array<string, mixed>
     */
    public function getParameters(Primitive $primitive): array
    {
        $method = new ReflectionMethod($this, 'run');

        if ($method->getNumberOfParameters() === 0) {
            return [];
        }

        $parameter = $method->getParameters()[0];

        if ($parameter->getName() === 'instance') {
            return ['instance' => $primitive];
        }

        $type = $parameter->getType();

        if ($type instanceof ReflectionNamedType && ! $type->isBuiltin()) {
            return [$type->getName() => $primitive];
        }

        return [$parameter->getName() => $primitive];
    }
}
