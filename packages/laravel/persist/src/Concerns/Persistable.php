<?php

declare(strict_types=1);

namespace Honed\Persist\Concerns;

use Honed\Persist\Drivers\CookieDriver;
use Honed\Persist\Drivers\Decorator;
use Honed\Persist\Facades\Persist;
use Illuminate\Support\Str;

/**
 * @implements \Honed\Persist\Contracts\CanPersistData
 */
trait Persistable
{
    /**
     * The name of the key when persisting data.
     */
    protected bool|string $persistKey = false;

    /**
     * The mapping of persistable properties to their drivers.
     *
     * @var array<string, \Honed\Persist\Drivers\Decorator>
     */
    protected array $persistables = [];

    /**
     * The default driver to use for persisting data for this instance.
     */
    protected ?string $driver;

    /**
     * Get the request to use for the store.
     *
     * @return \Illuminate\Http\Request
     */
    abstract public function getRequest(); 

    /**
     * Define the names of different persistable properties.
     *
     * @return array<int, string>
     */
    abstract public function persistables(): array;

    /**
     * Determine if the given key is persistable.
     */
    public function hasPersistable(string $key): bool
    {
        return isset($this->persistables[$key]);
    }

    /**
     * Dynamically handle calls to a persist method
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        
    }
    /**
     * Set the name of the key to use when persisting data to a store.
     *
     * @return $this
     */
    public function persistKey(string $key): self
    {
        $this->persistKey = $key;

        return $this;
    }

    /**
     * Get the name of the key to use when persisting data.
     */
    public function getPersistKey(): string
    {
        return $this->persistKey ??= $this->guessPersistKey();
    }

    /**
     * Set the store to use for persisting data by default.
     *
     * @return $this
     */
    public function persistIn(string $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Get the driver being used for persisting data for this instance by default.
     */
    public function getDefaultDriver(): ?string
    {
        return $this->driver;
    }

    /**
     * Set the time to live for the persistent data, if using the cookie store.
     *
     * @param  int  $seconds
     * @return $this
     */
    public function lifetime(int $seconds = 15724800): self
    {
        /** @var CookieStore $driver */
        $driver = $this->getDriver('cookie');

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
            ->snake('-')
            ->toString();
    }

    /**
     * Determine if the given key is apart of persistable values.
     */
    protected function isPersisting(string $key): bool
    {
        return in_array($key, $this->persistables());
    }

    /**
     * Get the store to use for persisting data.
     */
    protected function getDriver(bool|string $type): ?Decorator
    {
        if (! $type) {
            return null;
        }

        if ($type === true) {
            $type = $this->getDefaultDriver();
        }

        return Persist::store($type);
    }

    /**
     * Get the driver to use for a given key.
     * 
     * @return $this
     */
    protected function setDriver(string $name, string|bool $driver): self
    {
        $this->persistables[$name] = $driver;

        return $this;
    }
}
