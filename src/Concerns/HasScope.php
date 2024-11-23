<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasScope
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $scope = null;

    /**
     * Set the scope, chainable.
     *
     * @param  string|\Closure(mixed...)  $scope
     * @return $this
     */
    public function scope(string|\Closure $scope): static
    {
        $this->setScope($scope);

        return $this;
    }

    /**
     * Set the scope quietly.
     *
     * @param  string|(\Closure(mixed...):string)  $scope
     */
    public function setScope(string|\Closure|null $scope): void
    {
        if (is_null($scope)) {
            return;
        }
        $this->scope = $scope;
    }

    /**
     * Get the scope using the given closure dependencies.
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return string|null
     */
    public function getScope(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->scope, $named, $typed);
    }

    /**
     * Resolve the scope using the given closure dependencies.
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return string|null
     */
    public function resolveScope(array $named = [], array $typed = []): ?string
    {
        $this->setScope($this->getScope($named, $typed));

        return $this->scope;
    }

    /**
     * Determine if the class does not have a scope.
     *
     * @return bool
     */
    public function missingScope(): bool
    {
        return \is_null($this->scope);
    }

    /**
     * Determine if the class has a scope.
     *
     * @return bool
     */
    public function hasScope(): bool
    {
        return ! $this->missingScope();
    }
}
