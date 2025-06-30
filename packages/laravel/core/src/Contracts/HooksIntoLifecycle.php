<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

use Closure;

interface HooksIntoLifecycle
{
    /**
     * Set a callback to be called before the pipeline has begun.
     *
     * @param  (Closure(mixed...):mixed)|null  $callback
     * @return $this
     */
    public function before(?Closure $callback): static;

    /**
     * Get the callback to be called before the pipeline has begun.
     *
     * @return (Closure(mixed...):mixed)|null
     */
    public function beforeCallback(): ?Closure;

    /**
     * Call the before callback.
     *
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     */
    public function callBefore(array $named = [], array $typed = []): mixed;

    /**
     * Set a callback to be called after the pipeline has finished.
     *
     * @param  (Closure(mixed...):mixed)|null  $callback
     * @return $this
     */
    public function after(?Closure $callback): static;

    /**
     * Get the callback to be called after the pipeline has finished.
     *
     * @return (Closure(mixed...):mixed)|null
     */
    public function afterCallback(): ?Closure;

    /**
     * Call the after callback.
     *
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     */
    public function callAfter(array $named = [], array $typed = []): mixed;
}
