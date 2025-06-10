<?php

namespace Honed\Refine\Concerns;

use Illuminate\Support\Str;

trait CanPersistData
{
    /**
     * The name of the key when persisting data.
     * 
     * @var string|null
     */
    protected $persistKey;

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
     * Set the name of the key to use when persisting data.
     * 
     * @param string $key
     * @return $this
     */
    public function persistKey($key)
    {
        $this->persistKey = $key;

        return $this;
    }

    /**
     * Get the name of the key to use when persisting data.
     * 
     * @return string
     */
    public function getPersistKey()
    {
        return $this->persistKey ?? $this->guessPersistKey();
    }

    /**
     * Guess the name of the key to use when persisting data.
     * 
     * @return string
     */
    protected function guessPersistKey()
    {
        return Str::slug(class_basename(static::class));
    }

    /**
     * Set the driver to use for persisting searches.
     * 
     * @param bool|'session'|'cookie' $driver
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
        return $this->persistSearches('session');
    }

    /**
     * Set the cookie driver to be used for persisting searches.
     * 
     * @return $this
     */
    public function persistSearchInCookie()
    {
        return $this->persistSearches('cookie');
    }

    /**
     * Set the driver to use for persisting filters.
     * 
     * @param bool|'session'|'cookie' $driver
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
        return $this->persistFilters('session');
    }

    /**
     * Set the cookie driver to be used for persisting filters.
     * 
     * @return $this
     */
    public function persistFilterInCookie()
    {
        return $this->persistFilters('cookie');
    }

    /**
     * Set the driver to use for persisting sorts.
     * 
     * @param bool|'session'|'cookie' $driver
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
        return $this->persistSorts('session');
    }

    /**
     * Set the cookie driver to be used for persisting sorts.
     * 
     * @return $this
     */
    public function persistSortInCookie()
    {
        return $this->persistSorts('cookie');
    }

    /**
     * Set the driver to use for persisting all refinements.
     * 
     * @param bool|'session'|'cookie' $driver
     * @return $this
     */
    public function persistAll($driver = true)
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
    public function persistAllInCookie()
    {
        return $this->persistAll('cookie');
    }

    /**
     * Set the session driver to be used for persisting all refinements.
     * 
     * @return $this
     */
    public function persistAllInSession()
    {
        return $this->persistAll('session');
    }
    
}