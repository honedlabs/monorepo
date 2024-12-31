<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait Authorizable
{
    /**
     * @var bool|(\Closure(mixed...):bool)
     */
    protected $authorized = true;

    /**
     * Set the condition for authorization, chainable.
     *
     * @param  bool|\Closure(mixed...):bool  $condition
     * @return $this
     */
    public function authorize(bool|\Closure $condition = true): static
    {
        $this->setAuthorize($condition);

        return $this;
    }

    /**
     * Alias for `authorize`.
     *
     * @param  bool|\Closure(mixed...):bool  $condition
     * @return $this
     */
    public function authorise(bool|\Closure $condition = true): static
    {
        return $this->authorize($condition);
    }

    /**
     * Set the condition for authorization quietly.
     *
     * @param  bool|\Closure(mixed...):bool  $condition
     */
    public function setAuthorize(bool|\Closure $condition): void
    {
        $this->authorized = $condition;
    }

    /**
     * Alias for `setAuthorize`.
     *
     * @param  bool|\Closure(mixed...):bool  $condition
     */
    public function setAuthorise(bool|\Closure $condition): void
    {
        $this->setAuthorize($condition);
    }

    /**
     * Determine if the class is authorized using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function isAuthorized(array $named = [], array $typed = []): bool
    {
        return (bool) $this->evaluate($this->authorized, $named, $typed);
    }

    /**
     * Alias for `isAuthorized`.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function isAuthorised(array $named = [], array $typed = []): bool
    {
        return $this->isAuthorized($named, $typed);
    }
}
