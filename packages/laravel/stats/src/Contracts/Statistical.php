<?php

declare(strict_types=1);

namespace Honed\Stats\Contracts;

use Honed\Stats\Overview;

interface Statistical
{
    /**
     * Get the profile.
     */
    public function getOverview(): Overview;

    /**
     * Get the overview as a props array for spreading.
     *
     * @return array<string,mixed>
     */
    public function overviewProps(): array;
}
