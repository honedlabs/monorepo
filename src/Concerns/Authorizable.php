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
     * Alias for authorize
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
     * @param  bool|\Closure(mixed...):bool|null  $condition
     */
    public function setAuthorize(bool|\Closure|null $condition): void
    {
        if (is_null($condition)) {
            return;
        }
        $this->authorized = $condition;
    }

    /**
     * Alias for setAuthorize
     *
     * @param  bool|\Closure(mixed...):bool|null  $condition
     */
    public function setAuthorise(bool|\Closure|null $condition): void
    {
        $this->setAuthorize($condition);
    }

    /**
     * Determine if the class is authorized using the given closure dependencies.
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return bool
     */
    public function isAuthorized(array $named = [], array $typed = []): bool
    {
        return (bool) $this->evaluate($this->authorized, $named, $typed);
    }

    /**
     * Determine if the class is not authorized using the given closure dependencies.
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return bool
     */
    public function isNotAuthorized(array $named = [], array $typed = []): bool
    {
        return ! $this->isAuthorized($named, $typed);
    }

    /**
     * Alias for isAuthorized
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return bool
     */
    public function isAuthorised(array $named = [], array $typed = []): bool
    {
        return $this->isAuthorized($named, $typed);
    }

    /**
     * Alias for isNotAuthorized
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return bool
     */
    public function isNotAuthorised(array $named = [], array $typed = []): bool
    {
        return $this->isNotAuthorized($named, $typed);
    }
}
