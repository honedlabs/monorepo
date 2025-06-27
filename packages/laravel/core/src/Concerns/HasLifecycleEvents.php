<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

/**
 * @phpstan-require-implements \Honed\Core\Contracts\HooksIntoLifecycle
 */
trait HasLifecycleEvents
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
     * @return mixed
     */
    public function callAfter()
    {
        return $this->evaluate($this->afterCallback());
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
     * @return mixed
     */
    public function callBefore()
    {
        return $this->evaluate($this->beforeCallback());
    }
}
