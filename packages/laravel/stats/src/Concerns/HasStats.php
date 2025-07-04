<?php

declare(strict_types=1);

namespace Honed\Stat\Concerns;

use Honed\Stat\Stat;

trait HasStats
{
    /**
     * The stats.
     *
     * @var array<int,Stat>
     */
    protected $stats = [];

    /**
     * Get the stats.
     *
     * @param  array<int,\Honed\Stats\Stat>  $stats
     * @return $this
     */
    public function stats(array|Stat $stats): static
    {
        /** @var array<int,Stat> */
        $stats = is_array($stats) ? $stats : func_get_args();

        $this->stats = [...$this->stats, ...$stats];

        return $this;
    }

    /**
     * Get the stats for serialization.
     *
     * @return array<int,Stat>
     */
    public function getStats(): array
    {
        return $this->stats;
    }
}
