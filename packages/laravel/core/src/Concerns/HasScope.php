<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Str;

trait HasScope
{
    /**
     * The scope to use for the instance.
     *
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
        $this->scope = $scope;

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
        return isset($this->scope);
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

        return \sprintf('%s:%s', $this->getScope(), $value);
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
            ->after(':')
            ->toString();
    }
}
