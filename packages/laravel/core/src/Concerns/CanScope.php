<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Str;

trait CanScope
{
    public const SCOPE = ':';

    /**
     * The scope to use.
     *
     * @var string|null
     */
    protected $scope;

    /**
     * Set the scope.
     *
     * @return $this
     */
    public function scope(?string $scope): static
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Remove the scope
     *
     * @return $this
     */
    public function dontScope(): static
    {
        return $this->scope(null);
    }

    /**
     * Get the scope.
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * Format a value using the scope.
     */
    public function scoped(string $value): string
    {
        $scope = $this->getScope();

        return $scope ? $scope.self::SCOPE.$value : $value;
    }

    /**
     * Retrieve a value from a formatted scope.
     */
    public function unscoped(string $value): string
    {
        $scope = $this->getScope();

        return $scope ? Str::after($value, $scope.self::SCOPE) : $value;
    }
}
