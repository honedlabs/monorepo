<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasScope
{
    /**
     * @var string|(\Closure():string)|null
     */
    protected $scope = null;

    /**
     * Set the scope, chainable.
     *
     * @param  string|\Closure():string  $scope
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
     * @param  string|(\Closure():string)|null  $scope
     */
    public function setScope(string|\Closure|null $scope): void
    {
        if (is_null($scope)) {
            return;
        }
        $this->scope = $scope;
    }

    /**
     * Get the scope.
     */
    public function getScope(): ?string
    {
        return $this->evaluate($this->scope);
    }

    /**
     * Determine if the class does not have a scope.
     */
    public function missingScope(): bool
    {
        return \is_null($this->scope);
    }

    /**
     * Determine if the class has a scope.
     */
    public function hasScope(): bool
    {
        return ! $this->missingScope();
    }
}
