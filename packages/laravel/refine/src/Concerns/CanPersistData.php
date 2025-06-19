<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Refine\Persistence\CookieDriver;
use Honed\Refine\Persistence\Driver;
use Honed\Refine\Persistence\SessionDriver;
use Illuminate\Support\Str;

trait CanPersistData
{
    /**
     * The name of the key when persisting data.
     *
     * @var string|null
     */
    protected ?string $persistKey = null;

    /**
     * The default driver to use for persisting data.
     *
     * @var string
     */
    protected string $persistDriver = 'session';

    /**
     * The drivers to use for persisting data.
     *
     * @var array<string,\Honed\Refine\Persistence\Driver>
     */
    protected array $drivers = [];

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
    public function persistKey(string $key): self
    {
        $this->persistKey = $key;

        return $this;
    }

    /**
     * Get the name of the key to use when persisting data.
     *
     * @return string
     */
    public function getPersistKey(): string
    {
        return $this->persistKey ?? $this->guessPersistKey();
    }

    /**
     * Set the driver to use for persisting data by default.
     *
     * @param  string  $driver
     * @return $this
     */
    public function persistIn(string $driver): self
    {
        $this->persistDriver = $driver;

        return $this;
    }

    /**
     * Set the driver to use for persisting data to the session.
     *
     * @return $this
     */
    public function persistInSession(): self
    {
        return $this->persistIn(SessionDriver::NAME);
    }

    /**
     * Set the driver to use for persisting data to the cookie.
     *
     * @return $this
     */
    public function persistInCookie(): self
    {
        return $this->persistIn(CookieDriver::NAME);
    }

    /**
     * Set the time to live for the persistent data, if using the cookie driver.
     *
     * @param  int  $seconds
     * @return $this
     */
    public function lifetime(int $seconds = 15724800): self
    {
        /** @var CookieDriver $driver */
        $driver = $this->getPersistDriver(CookieDriver::NAME);

        $driver->lifetime($seconds);

        return $this;
    }

    /**
     * Persist the data to the drivers.
     *
     * @return void
     */
    public function persistData(): void
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
    protected function guessPersistKey(): string
    {
        return Str::of(static::class)
            ->classBasename()
            ->snake('-')
            ->toString();
    }

    /**
     * Get the driver to use for persisting data.
     *
     * @param  bool|string|null  $type
     * @return \Honed\Refine\Persistence\Driver|null
     */
    public function getPersistDriver(bool|string|null $type = null): ?Driver
    {
        if ($type === true) {
            $type = $this->persistDriver;
        }

        return match ($type) {
            CookieDriver::NAME => $this->newCookieDriver(),
            SessionDriver::NAME => $this->newSessionDriver(),
            default => null,
        };
    }

    /**
     * Create a new cookie driver instance.
     *
     * @return CookieDriver
     */
    protected function newCookieDriver(): CookieDriver
    {
        return $this->drivers[CookieDriver::NAME]
            ??= CookieDriver::make($this->getPersistKey())
                ->request($this->getRequest());
    }

    /**
     * Create a new session driver instance.
     *
     * @return SessionDriver
     */
    protected function newSessionDriver(): SessionDriver
    {
        return $this->drivers[SessionDriver::NAME]
            ??= SessionDriver::make($this->getPersistKey());
    }
}
