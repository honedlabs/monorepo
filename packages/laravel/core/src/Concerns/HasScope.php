<?php

namespace Honed\Core\Concerns;

use Illuminate\Support\Str;

use function sprintf;

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
     * @param  string|null  $scope
     * @return $this
     */
    public function scope($scope)
    {
        $this->scope = $scope;

        return $this;
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
        $scope = $this->getScope();

        if (! $scope) {
            return $value;
        }

        return sprintf('%s%s%s', $scope, self::SCOPE_SEPARATOR, $value);
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
            return Str::of($value)
                ->after(self::SCOPE_SEPARATOR)
                ->toString();
        }

        return $value;
    }
}
