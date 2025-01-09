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
     * Get or set the scope for the instance.
     * 
     * @param string|null $scope The scope to set, or null to retrieve the current scope.
     * @return string|null|$this The current scope when no argument is provided, or the instance when setting the scope.
     */
    public function scope($scope = null)
    {
        if (\is_null($scope)) {
            return $this->scope;
        }

        $this->scope = $scope;

        return $this;
    }

    /**
     * Determine if the instance has a scope set.
     * 
     * @return bool True if a scope is set, false otherwise.
     */
    public function hasScope()
    {
        return ! \is_null($this->scope);
    }
}
