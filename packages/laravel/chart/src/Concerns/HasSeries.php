<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Honed\Chart\Series\Series;

trait HasSeries
{
    /**
     * The series.
     * 
     * @var array<int, \Honed\Chart\Series\Series>
     */
    protected $series = [];

    /**
     * Merge the series.
     * 
     * @param \Honed\Chart\Series\Series|array<int, \Honed\Chart\Series\Series> $series
     * @return $this
     */
    public function series(Series|array $series): static
    {
        $series = is_array($series) ? $series : func_get_args();

        $this->series = [...$this->series, ...$series];

        return $this;
    }

    /**
     * Get the series.
     * 
     * @return array<int, \Honed\Chart\Series\Series>
     */
    public function getSeries(): array
    {
        return $this->series;
    }

    /**
     * Get the series representation.
     * 
     * @return array<int, array<string, mixed>>
     */
    public function seriesToArray(): array
    {
        return array_map(
            static fn (Series $series) => $series->toArray(),
            $this->getSeries()
        );
    }
}