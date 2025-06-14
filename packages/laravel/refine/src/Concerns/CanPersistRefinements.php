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
}
