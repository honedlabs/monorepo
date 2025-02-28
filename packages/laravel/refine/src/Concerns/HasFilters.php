<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Refine\Filters\Filter;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

trait HasFilters
{
    /**
     * List of the filters.
     *
     * @var array<int,\Honed\Refine\Filters\Filter>|null
     */
    protected $filters;

    /**
     * Merge a set of filters with the existing filters.
     *
     * @param  array<int, \Honed\Refine\Filters\Filter>|\Illuminate\Support\Collection<int, \Honed\Refine\Filters\Filter>  $filters
     * @return $this
     */
    public function addFilters($filters): static
    {
        if ($filters instanceof Collection) {
            $filters = $filters->all();
        }

        $this->filters = \array_merge($this->filters ?? [], $filters);

        return $this;
    }

    /**
     * Add a single filter to the list of filters.
     *
     * @return $this
     */
    public function addFilter(Filter $filter): static
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * Retrieve the filters.
     *
     * @return array<int,\Honed\Refine\Filters\Filter>
     */
    public function getFilters(): array
    {
        return once(function () {
            $methodFilters = method_exists($this, 'filters') ? $this->filters() : [];
            $propertyFilters = $this->filters ?? [];

            return \array_values(
                \array_filter(
                    \array_merge($propertyFilters, $methodFilters),
                    static fn (Filter $filter) => $filter->isAllowed()
                )
            );
        });
    }

    /**
     * Determines if the instance has any filters.
     */
    public function hasFilters(): bool
    {
        return filled($this->getFilters());
    }

    /**
     * Apply the filters to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @return $this
     */
    public function filter(Builder $builder, Request $request): static
    {
        foreach ($this->getFilters() as $filter) {
            $filter->apply($builder, $request);
        }

        return $this;
    }

    /**
     * Get the filters as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function filtersToArray(): array
    {
        return \array_map(
            static fn (Filter $filter) => $filter->toArray(),
            $this->getFilters()
        );
    }
}
