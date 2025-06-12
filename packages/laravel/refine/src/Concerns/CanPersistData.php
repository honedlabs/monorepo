<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Refine\Persistence\CookieDriver;
use Honed\Refine\Persistence\SessionDriver;
use Illuminate\Support\Str;

trait CanPersistData
{
    /**
     * The drivers to use for persisting data.
     *
     * @var array<string,\Honed\Refine\Persistence\Driver>
     */
    protected $drivers = [];

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
     * Set the time to live for the persistent data, if using the cookie driver.
     *
     * @param  int  $seconds
     * @return $this
     */
    public function lifetime($seconds = 15724800)
    {
        /** @var \Honed\Refine\Persistence\CookieDriver $driver */
        $driver = $this->getPersistDriver('cookie');

        $driver->lifetime($seconds);

        return $this;
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
     * @param  'session'|'cookie'  $type
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
     * @return \Honed\Refine\Persistence\CookieDriver
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
     * @return \Honed\Refine\Persistence\SessionDriver
     */
    protected function newSessionDriver()
    {
        return $this->drivers['session'] 
            ??= SessionDriver::make($this->getPersistKey());
    }
}
