<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

trait InteractsWithSystem
{
    /**
     * Determine if the current PHP version is the same as the given version, or greater.
     *
     * @param  scalar  $version
     */
    public function isPhp(mixed $version): bool
    {
        return phpversion() >= (string) $version;
    }

    /**
     * Determine if the current Laravel version is the same as the given version, or greater.
     *
     * @param  scalar  $version
     */
    public function isLaravel(mixed $version): bool
    {
        return app()->version() >= (string) $version;
    }
}
