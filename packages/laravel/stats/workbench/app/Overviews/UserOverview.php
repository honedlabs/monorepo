<?php

declare(strict_types=1);

namespace Workbench\App\Overviews;

use Honed\Stats\Overview;
use Honed\Stats\Stat;

class UserOverview extends Overview
{
    /**
     * Define the overview.
     *
     * @return $this
     */
    protected function definition(): static
    {
        return $this
            ->stat(Stat::make('users_count')->count());
    }
}