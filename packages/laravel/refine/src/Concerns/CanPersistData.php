<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Refine\Persistence\CookieDriver;
use Honed\Refine\Persistence\SessionDriver;
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
     * @var 'session'|'cookie'|string
     */
    protected $persistDriver = 'session';

    /**
     * The drivers to use for persisting data.
     *
     * @var array<string,\Honed\Refine\Persistence\Driver>
     */
    protected $drivers = [];

    /**
     * Get the request to use for the driver.
     *
     * @return \Illuminate\Http\Request
     */
    abstract public function getRequest();

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
     * Set the driver to use for persisting data by default.
     *
     * @param  'session'|'cookie'|string  $driver
     * @return $this
     */
    public function persistIn($driver)
    {
        $this->persistDriver = $driver;

        return $this;
    }

    /**
     * Set the driver to use for persisting data to the session.
     *
     * @return $this
     */
    public function persistInSession()
    {
        return $this->persistIn('session');
    }

    /**
     * Set the driver to use for persisting data to the cookie.
     *
     * @return $this
     */
    public function persistInCookie()
    {
        return $this->persistIn('cookie');
    }

    /**
     * Set the time to live for the persistent data, if using the cookie driver.
     *
     * @param  int  $seconds
     * @return $this
     */
    public function lifetime($seconds = 15724800)
    {
        /** @var CookieDriver $driver */
        $driver = $this->getPersistDriver('cookie');

        $driver->lifetime($seconds);

        return $this;
    }

    /**
     * Persist the data to the drivers.
     *
     * @return void
     */
    protected function persist()
    {
        foreach ($this->drivers as $driver) {
            $driver->persist();
        }
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

    /**
     * Get the driver to use for persisting data.
     *
     * @param  'session'|'cookie'|string  $type
     * @return \Honed\Refine\Persistence\Driver
     */
    protected function getPersistDriver($type)
    {
        return match ($type) {
            'cookie' => $this->newCookieDriver(),
            default => $this->newSessionDriver(),
        };
    }

    /**
     * Create a new cookie driver instance.
     *
     * @return CookieDriver
     */
    protected function newCookieDriver()
    {
        return $this->drivers['cookie']
            ??= CookieDriver::make($this->getPersistKey())
                ->request($this->getRequest());
    }

    /**
     * Create a new session driver instance.
     *
     * @return SessionDriver
     */
    protected function newSessionDriver()
    {
        return $this->drivers['session']
            ??= SessionDriver::make($this->getPersistKey());
    }
}
