<?php

namespace Honed\Refine\Concerns;

trait CanPersistData
{
    /**
     * The default driver to use for persisting data.
     * 
     * @var 'session'|'cookie'
     */
    protected $persistDriver = 'session';

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
     * @param bool|'session'|'cookie' $driver
     * @return $this
     */
    public function persistSearches($driver = true)
    {
        $this->persistSearch = $driver;

        return $this;
    }

    /**
     * Set the session driver to be used for persisting searches.
     * 
     * @return $this
     */
    public function persistSearchesToSession()
    {
        return $this->persistSearches('session');
    }

    /**
     * Set the cookie driver to be used for persisting searches.
     * 
     * @return $this
     */
    public function persistSearchesToCookie()
    {
        return $this->persistSearches('cookie');
    }

    /**
     * Set the driver to use for persisting filters.
     * 
     * @param bool|'session'|'cookie' $driver
     * @return $this
     */
    public function persistFilters($driver = true)
    {
        $this->persistSearch = $driver;

        return $this;
    }

    /**
     * Set the session driver to be used for persisting filters.
     * 
     * @return $this
     */
    public function persistFiltersToSession()
    {
        return $this->persistFilters('session');
    }

    /**
     * Set the cookie driver to be used for persisting filters.
     * 
     * @return $this
     */
    public function persistFiltersToCookie()
    {
        return $this->persistFilters('cookie');
    }

    /**
     * Set the driver to use for persisting sorts.
     * 
     * @param bool|'session'|'cookie' $driver
     * @return $this
     */
    public function persistSorts($driver = true)
    {
        $this->persistSort = $driver;

        return $this;
    }

    /**
     * Set the session driver to be used for persisting sorts.
     * 
     * @return $this
     */
    public function persistSortsToSession()
    {
        return $this->persistSorts('session');
    }

    /**
     * Set the cookie driver to be used for persisting sorts.
     * 
     * @return $this
     */
    public function persistSortsToCookie()
    {
        return $this->persistSorts('cookie');
    }
}