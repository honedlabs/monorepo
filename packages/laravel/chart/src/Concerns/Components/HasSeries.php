<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Honed\Chart\Series\Series;
use Illuminate\Support\Collection;

/**
 * @phpstan-require-extends \Honed\Chart\Chartable
 */
trait HasSeries
{
    /**
     * List of the series.
     *
     * @var Collection<int, Series>|null
     */
    protected $series;

    /**
     * Merge the series.
     *
     * @param  Series|array<int, Series>  $series
     * @return $this
     */
    public function series(Series|array $series): static
    {
        /** @var array<int, Series> */
        $series = is_array($series) ? $series : func_get_args();

        $this->series = $this->getSeries()->merge($series);

        return $this;
    }

    /**
     * Get the series.
     *
     * @return Collection<int, Series>
     */
    public function getSeries(): Collection
    {
        return $this->series ??= new Collection();
    }

    /**
     * Determine if the series requires axes to be provided.
     */
    public function requiresAxes(): bool
    {
        return $this->getSeries()
            ->contains(
                static fn (Series $series) => $series->requiresAxes()
            );
    }

    /**
     * Get the list of series.
     *
     * @return list<array<string, mixed>>
     */
    public function listSeries(): array
    {
        /** @var list<array<string, mixed>> */
        return array_map(
            static fn (Series $series) => $series->toArray(),
            $this->getSeries()->all()
        );
    }

    /**
     * Resolve the series with the given data.
     *
     * @param  list<mixed>  $data
     */
    protected function resolveSeries(mixed $data): void
    {
        foreach ($this->getSeries() as $series) {
            $series->resolve($data);
        }
    }
}
