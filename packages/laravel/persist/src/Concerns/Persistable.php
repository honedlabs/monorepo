<?php

declare(strict_types=1);

namespace Honed\Persist\Concerns;

use BadMethodCallException;
use Honed\Persist\Drivers\CookieDriver;
use Honed\Persist\Drivers\Decorator;
use Honed\Persist\Facades\Persist;
use Illuminate\Support\Str;

/**
 * @phpstan-require-implements \Honed\Persist\Contracts\CanPersistData
 */
trait Persistable
{
    /**
     * The name of the key when persisting data.
     */
    protected ?string $persistKey;

    /**
     * The mapping of persistable properties to their drivers.
     *
     * @var array<string, string|bool>
     */
    protected array $persistables = [];

    /**
     * The available drivers.
     *
     * @var array<int, Decorator>
     */
    protected array $drivers = [];

    /**
     * The default driver to use for persisting data for this instance.
     */
    protected ?string $driver;

    /**
     * Dynamically handle calls to a persist method
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if ($call = $this->getPersistableCall($method)) {
            return $this->callPersistable($call, $parameters);
        }

        throw new BadMethodCallException("Method {$method} does not exist.");
    }

    /**
     * Define the names of different persistable properties.
     *
     * @return array<int, string>
     */
    abstract public function persistables(): array;

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
    public function getDefaultDriver(): string
    {
        return $this->driver ??= Persist::getDefaultDriver();
    }

    /**
     * Set the time to live for the persistent data, if using the cookie store.
     *
     * @return $this
     */
    public function lifetime(int $seconds): self
    {
        /** @var CookieDriver $driver */
        $driver = $this->getDriver('cookie');

        $driver->lifetime($seconds);

        return $this;
    }

    /**
     * Determine if the given key is apart of persistable values.
     */
    public function isPersisting(string $key): bool
    {
        if (isset($this->persistables[$key])) {
            return (bool) $this->persistables[$key];
        }

        return false;
    }

    /**
     * Get the store to use for persisting data.
     */
    public function getDriver(bool|string $type): ?Decorator
    {
        if (! $type) {
            return null;
        }

        if ($type === true) {
            $type = $this->getDefaultDriver();
        }

        return $this->drivers[$type] ??= $this->newDriver($type);
    }

    /**
     * Get the driver to use for a given key.
     *
     * @return $this
     */
    public function setDriver(string $name, string|bool $driver): self
    {
        $this->persistables[$name] = $driver;

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
     * Create a new driver instance.
     */
    protected function newDriver(string $type): Decorator
    {
        return new Decorator(
            $this->getPersistKey(),
            Persist::driver($type)
        );
    }

    /**
     * Get the call to a persistable method.
     *
     * @return null|array{0: string, 1: string, 2: string|bool|null}
     */
    protected function getPersistableCall(string $method): ?array
    {
        if ($match = Str::match('/persist([A-Z].+)$/', $method)) {
            return ['setDriver', $match, null];
        }

        if ($match = Str::match('/isPersisting([A-Z].+)$/', $method)) {
            return ['isPersisting', $match, null];
        }

        if ($match = Str::match('/get([A-Z].+)Store/', $method)) {
            return ['getDriver', $match, null];
        }

        preg_match('/persist([A-Z].+)In([A-Z].+)$/', $method, $matches);

        if (count($matches) === 3) {
            return ['setDriver', $matches[1], $matches[2]];
        }

        return null;
    }

    /**
     * Call a persistable method.
     *
     * @param  array{0: string, 1: string, 2: string|null}  $call
     * @param  array<array-key, mixed>  $parameters
     *
     * @throws BadMethodCallException
     */
    protected function callPersistable(array $call, array $parameters): mixed
    {
        [$method, $p1, $p2] = $call;

        if (! in_array($p1, $this->persistables())) {
            throw new BadMethodCallException(
                "Property {$p1} is not a defined persistable property."
            );
        }

        return $this->{$method}(Str::camel($p1), $p2 ?? $parameters[0] ?? true);
    }
}
