<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasScope
{
    /**
     * @var string|null
     */
    protected $scope = null;

    /**
     * Set the scope, chainable.
     *
     * @return $this
     */
    public function scope(string $scope): static
    {
        $this->setScope($scope);

        return $this;
    }

    /**
     * Set the scope quietly.
     */
    public function setScope(?string $scope): void
    {
        if (\is_null($scope)) {
            return;
        }

        $this->scope = $scope;
    }

    /**
     * Get the scope using the given closure dependencies.
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * Determine if the class has a scope.
     */
    public function hasScope(): bool
    {
        return ! \is_null($this->scope);
    }
}
