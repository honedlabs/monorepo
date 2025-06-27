<?php

declare(strict_types=1);

namespace Honed\Core;

use Closure;

/**
 * @template TClass = mixed
 */
abstract class Pipe
{
    /**
     * The instance to pipe.
     *
     * @var TClass
     */
    protected $instance;

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
    public function handle($instance, $next)
    {
        $this->instance($instance);

        $this->run();

        return $next($this->instance);
    }

    /**
     * Set the instance to pipe.
     *
     * @param  TClass  $instance
     * @return void
     */
    public function instance($instance)
    {
        $this->instance = $instance;
    }

    /**
     * Get the instance to pipe.
     *
     * @return TClass
     */
    public function getInstance()
    {
        return $this->instance;
    }
}
