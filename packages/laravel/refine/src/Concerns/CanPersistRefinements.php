<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

trait CanPersistRefinements
{
    use CanPersistData;

    /**
     * The driver to use for persisting search data.
     *
     * @var bool|'session'|'cookie'|null
     */
    protected $persistSearch;

    /**
     * The driver to use for persisting filter data.
     *
     * @var bool|'session'|'cookie'|null
     */
    protected $persistFilter;

    /**
     * The driver to use for persisting sort data.
     *
     * @var bool|'session'|'cookie'|null
     */
    protected $persistSort;

    /**
     * Set the driver to use for persisting searches.
     *
     * @param  bool|'session'|'cookie'  $driver
     * @return $this
     */
    public function persistSearch($driver = true)
    {
        $this->persistSearch = $driver;

        return $this;
    }

    /**
     * Set the session driver to be used for persisting searches.
     *
     * @return $this
     */
    public function persistSearchInSession()
    {
        return $this->persistSearch('session');
    }

    /**
     * Set the cookie driver to be used for persisting searches.
     *
     * @return $this
     */
    public function persistSearchInCookie()
    {
        return $this->persistSearch('cookie');
    }

    /**
     * Set the driver to use for persisting filters.
     *
     * @param  bool|'session'|'cookie'  $driver
     * @return $this
     */
    public function persistFilter($driver = true)
    {
        $this->persistSearch = $driver;

        return $this;
    }

    /**
     * Set the session driver to be used for persisting filters.
     *
     * @return $this
     */
    public function persistFilterInSession()
    {
        return $this->persistFilter('session');
    }

    /**
     * Set the cookie driver to be used for persisting filters.
     *
     * @return $this
     */
    public function persistFilterInCookie()
    {
        return $this->persistFilter('cookie');
    }

    /**
     * Set the driver to use for persisting sorts.
     *
     * @param  bool|'session'|'cookie'  $driver
     * @return $this
     */
    public function persistSort($driver = true)
    {
        $this->persistSort = $driver;

        return $this;
    }

    /**
     * Set the session driver to be used for persisting sorts.
     *
     * @return $this
     */
    public function persistSortInSession()
    {
        return $this->persistSort('session');
    }

    /**
     * Set the cookie driver to be used for persisting sorts.
     *
     * @return $this
     */
    public function persistSortInCookie()
    {
        return $this->persistSort('cookie');
    }

    /**
     * Set the driver to use for persisting all refinements.
     *
     * @param  bool|'session'|'cookie'  $driver
     * @return $this
     */
    public function persistent($driver = true)
    {
        $this->persistSearch = $driver;
        $this->persistFilter = $driver;
        $this->persistSort = $driver;

        return $this;
    }

    /**
     * Push a search value into the internal data store.
     *
     * @param  \Honed\Refine\Filter  $filter
     * @param  mixed  $value
     * @return void
     */
    public function persistSearchValue($term, $columns = null)
    {
        $this->getPersistDriver($this->persistSearch)
            ?->merge('search', 'term', $term);

        if ($columns) {
            $this->getPersistDriver($this->persistSearch)
                ?->merge('search', 'cols', $columns);
        }
    }

    /**
     * Get a filter value from the internal data store.
     *
     * @param  \Honed\Refine\Filter  $filter
     * @return array<string|null, array<int,string>|null>
     */
    public function getPersistedSearchValue()
    {
        $term = $this->getPersistDriver($this->persistSearch)
            ?->get('search.term');

        $columns = $this->getPersistDriver($this->persistSearch)
            ?->get('search.cols');

        return [$term, $columns];
    }

    /**
     * Push a filter value into the internal data store.
     *
     * @param  \Honed\Refine\Filter  $filter
     * @param  mixed  $value
     * @return void
     */
    public function persistFilterValue($filter, $value)
    {
        $this->getPersistDriver($this->persistFilter)
            ?->merge('filters', $filter->getParameter(), $value);
    }

    /**
     * Get a filter value from the internal data store.
     *
     * @param  \Honed\Refine\Filter  $filter
     * @return mixed
     */
    public function getPersistedFilterValue($filter)
    {
        return $this->getPersistDriver($this->persistFilter)
            ?->get('filters.'.$filter->getParameter());
    }

    /**
     * Push the sort value into the internal data store.
     *
     * @param  string  $column
     * @param  string|null  $direction
     * @return void
     */
    public function persistSortValue($column, $direction)
    {
        $this->getPersistDriver($this->persistFilter)
            ?->merge('sorts', 'col', $column)
            ->merge('sorts', 'dir', $direction);
    }

    /**
     * Get a sort value from the internal data store.
     *
     * @return array<string|null, 'asc'|'desc'|null>
     */
    public function getPersistedSortValue()
    {
        $column = $this->getPersistDriver($this->persistFilter)
            ?->get('sorts.col');

        $direction = $this->getPersistDriver($this->persistFilter)
            ?->get('sorts.dir');

        return [$column, $direction];
    }
}
