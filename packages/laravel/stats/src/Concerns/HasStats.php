<?php

declare(strict_types=1);

namespace Honed\Stats\Concerns;

trait HasStats
{
    /**
     * Get the stats.
     *
     * @return array<int,\Honed\Stats\Stat>
     */
    abstract public function getStats(): array;
}