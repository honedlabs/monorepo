<?php

declare(strict_types=1);

namespace Honed\Stat\Contracts;

use Honed\Stat\Profile;

interface Profilable
{
    /**
     * Get the profile.
     */
    public function getProfile(): Profile;

    /**
     * Get the profile as an array for spreading.
     *
     * @return array<string,mixed>
     */
    public function profiler(): array;
}
