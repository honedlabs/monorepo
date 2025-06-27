<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

/**
 * @phpstan-require-implements \Honed\Core\Contracts\HooksIntoLifecycle
 */
trait HasLifecycleHooks
{
    /**
     * The callback to be called before the pipeline has finished.
     *
     * @var (Closure(mixed...):mixed|void)|null
     */
    protected $before;

    /**
     * The callback to be called after the pipeline has finished.
     *
     * @var (Closure(mixed...):mixed|void)|null
     */
    protected $after;

    /**
     * Set a callback to be called after the pipeline has finished.
     *
     * @param  (Closure(mixed...):mixed|void)|null  $callback
     * @return $this
     */
    public function after($callback)
    {
        $this->after = $callback;

        return $this;
    }

    /**
     * Get the callback to be called after the pipeline has finished.
     *
     * @return (Closure(mixed...):mixed|void)|null
     */
    public function afterCallback()
    {
        return $this->after;
    }

    /**
     * Call the after callback.
     *
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     * @return mixed
     */
    public function callAfter($named = [], $typed = [])
    {
        return $this->evaluate($this->afterCallback(), $named, $typed);
    }

    /**
     * Set a callback to be called before the pipeline has begun.
     *
     * @param  (Closure(mixed...):mixed|void)|null  $callback
     * @return $this
     */
    public function before($callback)
    {
        $this->before = $callback;

        return $this;
    }

    /**
     * Get the callback to be called before the pipeline has begun.
     *
     * @return (Closure(mixed...):mixed|void)|null
     */
    public function beforeCallback()
    {
        return $this->before;
    }

    /**
     * Call the before callback.
     *
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     * @return mixed
     */
    public function callBefore($named = [], $typed = [])
    {
        return $this->evaluate($this->beforeCallback(), $named, $typed);
    }
}
