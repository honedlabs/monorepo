<?php

declare(strict_types=1);

namespace Honed\Refine\Filters\Concerns;

use function array_map;
use function array_filter;

use function array_values;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Honed\Refine\Filters\Filter;

trait HasFilters
{
    /**
     * Whether the filters should be applied.
     *
     * @var bool
     */
    protected bool $filterable = true;

    /**
     * List of the filters.
     *
     * @var array<int,Filter>
     */
    protected array $filters = [];

    /**
     * Set whether the filters should be applied.
     *
     * @param  bool  $enable
     * @return $this
     */
    public function filterable(bool $enable = true): self
    {
        $this->filterable = $enable;

        return $this;
    }

    /**
     * Set whether the filters should not be applied.
     *
     * @param  bool  $disable
     * @return $this
     */
    public function notFilterable(bool $disable = true): self
    {
        return $this->filterable(! $disable);
    }

    /**
     * Determine if the filters should be applied.
     *
     * @return bool
     */
    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    /**
     * Determine if the filters should not be applied.
     *
     * @return bool
     */
    public function isNotFilterable(): bool
    {
        return ! $this->isFilterable();
    }

    /**
     * Merge a set of filters with the existing filters.
     *
     * @param  Filter|array<int, Filter>  $filters
     * @return $this
     */
    public function filters(Filter|array $filters): self
    {
        /** @var array<int, Filter> $filters */
        $filters = is_array($filters) ? $filters : func_get_args();

        $this->filters = [...$this->filters, ...$filters];

        return $this;
    }

    /**
     * Retrieve the filters.
     *
     * @return array<int,Filter>
     */
    public function getFilters(): array
    {
        if ($this->isNotFilterable()) {
            return [];
        }

        return once(fn () => array_values(
            array_filter(
                $this->filters,
                static fn (Filter $filter) => $filter->isAllowed()
            )
        ));
    }

    /**
     * Determine if there is a filter being applied.
     *
     * @return bool
     */
    public function isFiltering(): bool
    {
        return (bool) Arr::first(
            $this->getFilters(),
            static fn (Filter $filter) => $filter->isActive()
        );
    }

    /**
     * Get the filter value from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Filter  $filter
     * @return mixed
     */
    public function getFilterValue(Request $request, Filter $filter): mixed
    {
        $key = $this->formatScope($filter->getParameter());

        $delimiter = $this->getDelimiter();

        return $filter->interpret($request, $key, $delimiter);
    }

    /**
     * Get the filters as an array for serialization.
     *
     * @return array<int,array<string,mixed>>
     */
    public function filtersToArray(): array
    {
        return array_values(
            array_map(
                static fn (Filter $filter) => $filter->toArray(),
                array_filter(
                    $this->getFilters(),
                    static fn (Filter $filter) => $filter->isVisible()
                )
            )
        );
    }
}
