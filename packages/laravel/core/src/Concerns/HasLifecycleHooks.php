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
     * @var (Closure():mixed|void)|null
     */
    protected $before;

    /**
     * The callback to be called after the pipeline has finished.
     *
     * @var (Closure():mixed|void)|null
     */
    protected ?Closure $after = null;

    /**
     * Set a callback to be called before the pipeline has begun.
     *
     * @param  (Closure():mixed|void)|null  $callback
     * @return $this
     */
    public function before(?Closure $callback): static
    {
        $this->before = $callback;

        return $this;
    }

    /**
     * Get the callback to be called before the pipeline has begun.
     *
     * @return (Closure():mixed|void)|null
     */
    public function beforeCallback(): ?Closure
    {
        return $this->before;
    }

    /**
     * Call the before callback.
     *
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     */
    public function callBefore(array $named = [], array $typed = []): mixed
    {
        return $this->evaluate($this->beforeCallback(), $named, $typed);
    }

    /**
     * Set a callback to be called after the pipeline has finished.
     *
     * @param  (Closure():mixed|void)|null  $callback
     * @return $this
     */
    public function after(?Closure $callback): static
    {
        $this->after = $callback;

        return $this;
    }

    /**
     * Get the callback to be called after the pipeline has finished.
     *
     * @return (Closure():mixed|void)|null
     */
    public function afterCallback(): ?Closure
    {
        return $this->after;
    }

    /**
     * Call the after callback.
     *
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     */
    public function callAfter(array $named = [], array $typed = []): mixed
    {
        return $this->evaluate($this->afterCallback(), $named, $typed);
    }
}
