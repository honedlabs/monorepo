<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasScope
{
    /**
     * @var string|null
     */
    protected $scope;

    /**
     * Set the scope for the instance.
     *
     * @return $this
     */
    public function scope(?string $scope): static
    {
        if (! \is_null($scope)) {
            $this->scope = $scope;
        }

        return $this;
    }

    /**
     * Get the scope for the instance.
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * Determine if the instance has an scope set.
     */
    public function hasScope(): bool
    {
        return ! \is_null($this->scope);
    }

    /**
     * Format a value using the scope for the instance.
     */
    public function formatScope(string $value): string
    {
        if (! $this->hasScope()) {
            return $value;
        }

        return \sprintf('%s[%s]', $this->getScope(), $value);
    }

    /**
     * Retrieve a value from a formatted scope.
     */
    public function decodeScope(string $value): string
    {
        return \str($value)
            ->afterLast('[')
            ->beforeLast(']')
            ->toString();
    }
}
