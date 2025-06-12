<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Illuminate\Support\Str;

trait CanBePersisted
{
    /**
     * The instance of the persistence manager.
     *
     * @var mixed
     */
    protected $persist;

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
     * The time to live for the persistent data, if using the cookie driver.
     *
     * @var int
     */
    protected $persistFor = 15724800;

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
     * @param  string  $key
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
     * Set the default driver to use for persisting data.
     *
     * @param  'session'|'cookie'  $driver
     * @return $this
     */
    public function persistUsing($driver)
    {
        $this->persistDriver = $driver;

        return $this;
    }

    /**
     * Get the default driver to use for persisting data.
     *
     * @return 'session'|'cookie'
     */
    public function getPersistDriver()
    {
        return $this->persistDriver;
    }

    /**
     * Set the time to live for the persistent data, if using the cookie driver.
     *
     * @param  int  $seconds
     * @return $this
     */
    public function persistFor($seconds = 15724800)
    {
        $this->persistFor = $seconds;

        return $this;
    }

    /**
     * Get the time to live for the persistent data, if using the cookie driver.
     *
     * @return int
     */
    public function getPersistDuration()
    {
        return $this->persistFor;
    }

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
     * Set the cookie driver to be used for persisting all refinements.
     *
     * @return $this
     */
    public function persistInCookie()
    {
        return $this->persistent('cookie');
    }

    /**
     * Set the session driver to be used for persisting all refinements.
     *
     * @return $this
     */
    public function persistInSession()
    {
        return $this->persistent('session');
    }

    /**
     * Guess the name of the key to use when persisting data.
     *
     * @return string
     */
    protected function guessPersistKey()
    {
        return Str::of(static::class)
            ->classBasename()
            ->slug()
            ->toString();
    }
}
