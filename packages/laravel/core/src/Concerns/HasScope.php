<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\CoreServiceProvider;
use Illuminate\Support\Str;

trait HasScope
{
    /**
     * @var string|null
     */
    protected $scope;

    /**
     * Set the scope for the instance.
     *
     * @param  string|null  $scope
     * @return $this
     */
    public function scope($scope)
    {
        if (! \is_null($scope)) {
            $this->scope = $scope;
        }

        return $this;
    }

    /**
     * Get the scope for the instance.
     *
     * @return string|null
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Determine if the instance has an scope set.
     *
     * @return bool
     */
    public function hasScope()
    {
        return ! \is_null($this->scope);
    }

    /**
     * Format a value using the scope for the instance.
     *
     * @param  string  $value
     * @return string
     */
    public function formatScope($value)
    {
        if (! $this->hasScope()) {
            return $value;
        }

        return \sprintf('%s%s%s', $this->getScope(), CoreServiceProvider::SCOPE_DELIMITER, $value);
    }

    /**
     * Retrieve a value from a formatted scope.
     *
     * @param  string  $value
     * @return string
     */
    public function decodeScope($value)
    {
        return Str::of($value)
            ->after(CoreServiceProvider::SCOPE_DELIMITER)
            ->toString();
    }
}
