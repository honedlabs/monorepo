<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Core\Concerns\HasRequest;
use Honed\Refine\Filter;
use Illuminate\Support\Collection;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
trait HasFilters
{
    /**
     * List of the filters.
     *
     * @var array<int,\Honed\Refine\Filter>|null
     */
    protected $filters;

    /**
     * Whether to not apply the filters.
     * 
     * @var bool
     */
    protected $withoutFiltering = false;

    /**
     * Whether to not provide the filters when serializing.
     * 
     * @var bool
     */
    protected $withoutFilters = false;

    /**
     * Merge a set of filters with the existing filters.
     *
     * @param  array<int, \Honed\Refine\Filter>|\Illuminate\Support\Collection<int, \Honed\Refine\Filter>  $filters
     * @return $this
     */
    public function addFilters($filters)
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
     * @param  \Honed\Refine\Filter  $filter
     * @return $this
     */
    public function addFilter($filter)
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * Retrieve the filters.
     *
     * @return array<int,\Honed\Refine\Filter>
     */
    public function getFilters()
    {
        return once(function () {
            $methodFilters = method_exists($this, 'filters') ? $this->filters() : [];
            $propertyFilters = $this->filters ?? [];

            return collect($propertyFilters)
                ->merge($methodFilters)
                ->filter(static fn (Filter $filter) => $filter->isAllowed())
                ->unique(static fn (Filter $filter) => $filter->getUniqueKey())
                ->values()
                ->all();
        });
    }

    /**
     * Determines if the instance has any filters.
     *
     * @return bool
     */
    public function hasFilters()
    {
        return filled($this->getFilters());
    }

    /**
     * Set the instance to not apply the filters.
     *
     * @param  bool  $withoutFiltering
     * @return $this
     */
    public function withoutFiltering($withoutFiltering = true)
    {
        $this->withoutFiltering = $withoutFiltering;

        return $this;
    }

    /**
     * Set the instance to not provide the filters when serializing.
     *
     * @param  bool  $withoutFilters
     * @return $this
     */
    public function withoutFilters($withoutFilters = true)
    {
        $this->withoutFilters = $withoutFilters;

        return $this;
    }

    /**
     * Determine if the instance should not apply the filters.
     *
     * @return bool
     */
    public function isWithoutFiltering()
    {
        return $this->withoutFiltering;
    }

    /**
     * Determine if the instance should not provide the filters when serializing.
     *
     * @return bool
     */
    public function isWithoutFilters()
    {
        return $this->withoutFilters;
    }

    /**
     * Apply the filters to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<TModel>  $builder
     * @param  \Illuminate\Http\Request  $request
     * @param  array<int, \Honed\Refine\Filter>  $additionalFilters
     * @return $this
     */
    public function filter($builder, $request, $additionalFilters = [])
    {
        if ($this->isWithoutFiltering()) {
            return $this;
        }

        $filters = \array_merge($this->getFilters(), $additionalFilters);

        foreach ($filters as $filter) {
            $filter->scope($this->getScope())->apply($builder, $request);
        }

        return $this;
    }

    /**
     * Get the filters as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function filtersToArray()
    {
        if ($this->isWithoutFilters()) {
            return [];
        }

        return \array_map(
            static fn (Filter $filter) => $filter->toArray(),
            $this->getFilters()
        );
    }
}
