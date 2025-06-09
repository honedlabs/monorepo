<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Refine\Sort;
use Illuminate\Support\Arr;

use function array_filter;
use function array_map;
use function array_merge;
use function array_values;

trait HasSorts
{
    /**
     * Whether the sorts should be applied.
     *
     * @var bool
     */
    protected $sortable = true;

    /**
     * List of the sorts.
     *
     * @var array<int,Sort>
     */
    protected $sorts = [];

    /**
     * The query parameter to identify the sort to apply.
     *
     * @var string
     */
    protected $sortKey = 'sort';

    /**
     * Set whether the sorts should be applied.
     *
     * @param  bool  $enable
     * @return $this
     */
    public function sortable($enable = true)
    {
        $this->sortable = $enable;

        return $this;
    }

    /**
     * Set whether the sorts should not be applied.
     * 
     * @param  bool  $sortable
     * @return $this
     */
    public function notSortable($disable = true)
    {
        $this->sortable = ! $disable;

        return $this;
    }

    /**
     * Determine if the sorts should be applied.
     *
     * @return bool
     */
    public function isSortable()
    {
        return $this->sortable;
    }

    /**
     * Determine if the sorts should not be applied.
     *
     * @return bool
     */
    public function isNotSortable()
    {
        return ! $this->isSortable();
    }


    /**
     * Merge a set of sorts with the existing sorts.
     *
     * @param  Sort|iterable<int, Sort>  ...$sorts
     * @return $this
     */
    public function sorts(...$sorts)
    {
        /** @var array<int, Sort> $sorts */
        $sorts = Arr::flatten($sorts);

        $this->sorts = array_merge($this->sorts, $sorts);

        return $this;
    }

    /**
     * Retrieve the sorts.
     *
     * @return array<int,Sort>
     */
    public function getSorts()
    {
        if ($this->isNotSortable()) {
            return [];
        }

        return array_values(
            array_filter(
                $this->sorts,
                static fn (Sort $sort) => $sort->isAllowed()
            )
        );
    }

    /**
     * Set a default sort, which will not be serialized.
     * 
     * @param string|Sort|\Closure $sort
     * @param string $direction
     * @return $this
     */
    public function defaultSort($sort, $direction = 'desc')
    {
        $this->defaultSort = $sort;

        return $this;
    }

    /**
     * Get the default sort.
     *
     * @return Sort|null
     */
    public function getDefaultSort()
    {
        return Arr::first(
            $this->getSorts(),
            static fn (Sort $sort) => $sort->isDefault()
        );
    }

    /**
     * Set the query parameter to identify the sort to apply.
     *
     * @param  string  $sortKey
     * @return $this
     */
    public function sortKey($sortKey)
    {
        $this->sortKey = $sortKey;

        return $this;
    }

    /**
     * Get the query parameter to identify the sort to apply.
     *
     * @return string
     */
    public function getSortKey()
    {
        return $this->formatScope($this->sortKey);
    }

    /**
     * Determine if there is a sort being applied.
     *
     * @return bool
     */
    public function isSorting()
    {
        return (bool) Arr::first(
            $this->getSorts(),
            static fn (Sort $sort) => $sort->isActive()
        );
    }

    /**
     * Get the sorts as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function sortsToArray()
    {
        return array_map(
            static fn (Sort $sort) => $sort->toArray(),
            $this->getSorts()
        );
    }
}
