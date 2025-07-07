<?php

declare(strict_types=1);

namespace Honed\Honed\Responses\Concerns;

use Honed\Honed\Contracts\ViewsModel;
use Honed\Stats\Overview;

/**
 * @template TStats of \Honed\Stats\Overview = \Honed\Stats\Overview
 */
trait CanHaveStats
{
    /**
     * The stats to use for the view.
     *
     * @var bool|class-string<TStats>|TStats
     */
    protected $stats = false;

    /**
     * Set the stats.
     *
     * @param  class-string<TStats>|TStats|null  $value
     * @return $this
     */
    public function stats(bool|string|Overview $value = true): static
    {
        $this->stats = $value;

        return $this;
    }

    /**
     * Get the stats to use for the view.
     *
     * @return TStats|null
     */
    public function getStats(): ?Overview
    {
        return match (true) {
            is_string($this->stats) => ($this->stats)::make(),
            $this->stats instanceof Overview => $this->stats,
            $this->stats === true &&
                $this instanceof ViewsModel => $this->getModel()->stats(),
            default => null,
        };
    }

    /**
     * Convert the stats to props.
     *
     * @return array<string, mixed>
     */
    protected function canHaveStatsToProps(): array
    {
        if ($stats = $this->getStats()) {
            return $stats->toArray();
        }

        return [];
    }
}
