<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Str;

trait HasScope
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
     * Format a value using the scope.
     *
     * @param  string  $value
     * @return string
     */
    public function scoped($value)
    {
        $scope = $this->getScope();

        return $scope ? $scope.self::SCOPE.$value : $value;
    }

    /**
     * Retrieve a value from a formatted scope.
     *
     * @param  string  $value
     * @return string
     */
    public function unscoped($value)
    {
        $scope = $this->getScope();

        return $scope ? Str::after($value, $scope.self::SCOPE) : $value;
    }
}
