<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Refine\Sort;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
trait HasSorts
{
    /**
     * The query parameter to identify the sort to apply.
     *
     * @var string|null
     */
    protected $sortsKey;

    /**
     * List of the sorts.
     *
     * @var array<int,\Honed\Refine\Sort>|null
     */
    protected $sorts;

    /**
     * Whether to not apply the sorts.
     * 
     * @var bool
     */
    protected $withoutSorting = false;

    /**
     * Whether to not provide the sorts when serializing.
     * 
     * @var bool
     */
    protected $withoutSorts = false;

    /**
     * Set the query parameter to identify the sort to apply.
     *
     * @param  string  $sortsKey
     * @return $this
     */
    public function sortsKey($sortsKey)
    {
        $this->sortsKey = $sortsKey;

        return $this;
    }

    /**
     * Get the query parameter to identify the sort to apply.
     *
     * @return string
     */
    public function getSortsKey()
    {
        if (isset($this->sortsKey)) {
            return $this->sortsKey;
        }

        return $this->fallbackSortsKey();
    }

    /**
     * Get the fallback query parameter to identify the sort to apply.
     *
     * @return string
     */
    protected function fallbackSortsKey()
    {
        return type(config('refine.config.sorts', 'sort'))->asString();
    }

    /**
     * Merge a set of sorts with the existing sorts.
     *
     * @param  array<int, \Honed\Refine\Sort>|\Illuminate\Support\Collection<int, \Honed\Refine\Sort>  $sorts
     * @return $this
     */
    public function addSorts($sorts)
    {
        if ($sorts instanceof Collection) {
            $sorts = $sorts->all();
        }

        $this->sorts = \array_merge($this->sorts ?? [], $sorts);

        return $this;
    }

    /**
     * Add a single sort to the list of sorts.
     *
     * @param  \Honed\Refine\Sort  $sort
     * @return $this
     */
    public function addSort($sort)
    {
        $this->sorts[] = $sort;

        return $this;
    }

    /**
     * Retrieve the sorts.
     *
     * @return array<int,\Honed\Refine\Sort>
     */
    public function getSorts()
    {
        return once(function () {
            $methodSorts = method_exists($this, 'sorts') ? $this->sorts() : [];
            $propertySorts = $this->sorts ?? [];

            return collect($propertySorts)
                ->merge($methodSorts)
                ->filter(static fn (Sort $sort) => $sort->isAllowed())
                ->unique(static fn (Sort $sort) => $sort->getUniqueKey())
                ->values()
                ->all();
        });
    }

    /**
     * Determines if the instance has any sorts.
     *
     * @return bool
     */
    public function hasSorts()
    {
        return filled($this->getSorts());
    }

    /**
     * Set the instance to not apply the sorts.
     *
     * @param  bool  $withoutSorting
     * @return $this
     */
    public function withoutSorting($withoutSorting = true)
    {
        $this->withoutSorting = $withoutSorting;

        return $this;
    }

    /**
     * Set the instance to not provide the sorts when serializing.
     *
     * @param  bool  $withoutSorts
     * @return $this
     */
    public function withoutSorts($withoutSorts = true)
    {
        $this->withoutSorts = $withoutSorts;

        return $this;
    }

    /**
     * Determine if the instance should not apply the sorts.
     *
     * @return bool
     */
    public function isWithoutSorting()
    {
        return $this->withoutSorting;
    }

    /**
     * Determine if the instance should not provide the sorts when serializing.
     *
     * @return bool
     */
    public function isWithoutSorts()
    {
        return $this->withoutSorts;
    }

    /**
     * Apply the sort to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<TModel>  $builder
     * @param  \Illuminate\Http\Request  $request
     * @param  array<int, \Honed\Refine\Sort>  $additionalSorts
     * @return $this
     */
    public function sort($builder, $request, $additionalSorts = [])
    {
        if ($this->isWithoutSorting()) {
            return $this;
        }

        /** @var string */
        $key = $this->formatScope($this->getSortsKey());

        $sorts = \array_merge($this->getSorts(), $additionalSorts);

        $applied = false;

        foreach ($sorts as $sort) {
            $applied |= $sort->apply($builder, $request, $key);
        }

        if (! $applied) {
            $this->sortByDefault($builder, $sorts);
        }

        return $this;
    }

    /**
     * Apply a default sort to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<TModel>  $builder
     * @param  array<int, \Honed\Refine\Sort>  $sorts
     * @return void
     */
    protected function sortByDefault($builder, $sorts)
    {
        $sort = Arr::first(
            $sorts,
            static fn (Sort $sort) => $sort->isDefault()
        );

        $sort?->handle(
            $builder,
            $sort->getDirection() ?? 'asc',
            $sort->getName()
        );
    }

    /**
     * Get the sorts as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function sortsToArray()
    {
        if ($this->isWithoutSorts()) {
            return [];
        }

        return \array_map(
            static fn (Sort $sort) => $sort->toArray(),
            $this->getSorts()
        );
    }
}
