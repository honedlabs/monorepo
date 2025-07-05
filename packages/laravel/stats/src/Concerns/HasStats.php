<?php

declare(strict_types=1);

namespace Honed\Stats\Concerns;

use Honed\Stats\Stat;

trait HasStats
{
    /**
     * The stats.
     *
     * @var array<int,Stat>
     */
    protected $stats = [];

    /**
     * Add stats to the instance.
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
     * Add a stat to the instance.
     *
     * @param  \Honed\Stats\Stat  $stat
     * @return $this
     */
    public function stat(Stat $stat): static
    {
        return $this->stats($stat);
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
