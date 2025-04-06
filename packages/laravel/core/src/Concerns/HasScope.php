<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Str;

trait HasScope
{
    /**
     * The scope to use.
     *
     * @var string|null
     */
    protected $scope;

    /**
     * Set the scope.
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
     * Define the scope.
     *
     * @return string|null
     */
    public function defineScope()
    {
        return null;
    }

    /**
     * Get the scope.
     *
     * @return string|null
     */
    public function getScope()
    {
        return $this->scope ??= $this->defineScope();
    }

    /**
     * Determine if the scope is set.
     *
     * @return bool
     */
    public function hasScope()
    {
        return filled($this->getScope());
    }

    /**
     * Format a value using the scope.
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
