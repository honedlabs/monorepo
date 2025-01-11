<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasScope
{
    /**
     * @var string
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
        return isset($this->scope);
    }
}
