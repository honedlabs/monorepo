<?php

declare(strict_types=1);

namespace Honed\Core;

use Closure;
use Honed\Core\Concerns\HasInstance;

/**
 * @template TClass = mixed
 */
abstract class Pipe
{
    /** @use HasInstance<TClass> */
    use HasInstance {
        __call as instanceCall;
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param  string  $method
     * @param  array<array-key,mixed>  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->instanceCall($method, $parameters);
    }

    /**
     * Run the pipe logic.
     */
    abstract public function run(): void;

    /**
     * Apply the pipe.
     *
     * @param  TClass  $instance
     * @param  Closure(TClass): TClass  $next
     * @return TClass
     */
    public function handle($instance, Closure $next)
    {
        $this->through($instance);

        return $next($instance);
    }

    /**
     * Run the instance through the pipe.
     *
     * @param  TClass  $instance
     */
    public function through($instance): void
    {
        $this->instance($instance)->run();
    }
}
