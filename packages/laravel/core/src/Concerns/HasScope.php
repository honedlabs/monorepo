<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Str;

trait HasScope
{
    public const SCOPE_SEPARATOR = ':';

    /**
     * The scope to use.
     *
     * @var string|null
     */
    protected $scope;

    /**
     * Set the scope.
     *
     * @param  string|null  $value
     * @return $this
     */
    public function scope($value)
    {
        $this->scope = $value;

        return $this;
    }

    /**
     * Remove the scope
     *
     * @return $this
     */
    public function dontScope()
    {
        return $this->scope(null);
    }

    /**
     * Get the scope.
     *
     * @return string|null
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Determine if the scope is set.
     *
     * @return bool
     */
    public function hasScope()
    {
        return isset($this->scope);
    }

    /**
     * Format a value using the scope.
     *
     * @param  string  $value
     * @return string
     */
    public function formatScope($value)
    {
        $scope = $this->getScope();

        if (! $scope) {
            return $value;
        }

        return $scope.self::SCOPE_SEPARATOR.$value;
    }

    /**
     * Retrieve a value from a formatted scope.
     *
     * @param  string  $value
     * @return string
     */
    public function decodeScope($value)
    {
        if ($this->hasScope()) {
            return Str::after($value, self::SCOPE_SEPARATOR);
        }

        return $value;
    }
}
