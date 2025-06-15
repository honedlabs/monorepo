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
    public function persist($driver = true)
    {
        $this->persistSearch = $driver;
        $this->persistFilter = $driver;
        $this->persistSort = $driver;

        return $this;
    }

    /**
     * Set the cookie driver to be used for persisting all refinements.
     *
     * @return $this
     */
    public function persistInCookie()
    {
        return $this->persist('cookie');
    }

    /**
     * Set the session driver to be used for persisting all refinements.
     *
     * @return $this
     */
    public function persistInSession()
    {
        return $this->persist('session');
    }

    /**
     * Get the driver to use for persisting filter data.
     *
     * @return \Honed\Refine\Persistence\Driver|null
     */
    protected function get()
    {
        return $this->getPersistDriver($this->persistFilter);
    }

    /**
     * Push a search value into the internal data store.
     *
     * @param  \Honed\Refine\Filter  $filter
     * @param  mixed  $value
     * @return void
     */
    protected function persistSearchValue($term, $columns = null)
    {
        $this->getPersistDriver($this->persistFilter)
            ?->merge('search', 'term', $term);

        if ($columns) {
            $this->getPersistDriver($this->persistFilter)
                ?->merge('search', 'cols', $columns);
        }
    }

    /**
     * Get a filter value from the internal data store.
     *
     * @param  \Honed\Refine\Filter  $filter
     * @return array<string|null, array<int,string>|null>
     */
    protected function getPersistedSearchValue()
    {
        $term = $this->getPersistDriver($this->persistFilter)
            ?->get('search.term');

        $columns = $this->getPersistDriver($this->persistFilter)
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
    protected function persistFilterValue($filter, $value)
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
    protected function getPersistedFilterValue($filter)
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
    protected function persistSortValue($column, $direction)
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
    protected function getPersistedSortValue()
    {
        $column = $this->getPersistDriver($this->persistFilter)
            ?->get('sorts.col');

        $direction = $this->getPersistDriver($this->persistFilter)
            ?->get('sorts.dir');

        return [$column, $direction];
    }
}
