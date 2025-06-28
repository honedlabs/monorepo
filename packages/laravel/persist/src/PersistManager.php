<?php

declare(strict_types=1);

namespace Honed\Persist;

use Closure;
use Honed\Persist\Drivers\ArrayDriver;
use Honed\Persist\Drivers\SessionDriver;
use Honed\Persist\Drivers\CookieDriver;
use Honed\Persist\Drivers\Driver;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use RuntimeException;

class PersistManager
{
    /**
     * The container instance.
     *
     * @var Container
     */
    protected $container;

    /**
     * The array of resolved persist stores.
     *
     * @var array<string, Decorator>
     */
    protected $stores = [];

    /**
     * The registered custom driver creators.
     *
     * @var array<string, Closure(string, Container): Contracts\Driver>
     */
    protected $customCreators = [];

    /**
     * Create a new view resolver.
     *
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get a new driver instance.
     *
     * @param  string  $key
     * @param  string|null  $store
     * @return Driver
     *
     * @throws InvalidArgumentException
     */
    public function store(string $key, ?string $store = null): Driver
    {
        return $this->driver($key, $store);
    }

    /**
     * Get a new driver instance.
     *
     * @param  string  $key
     * @param  string  $store
     * @return Driver
     *
     * @throws InvalidArgumentException
     */
    public function driver(string $key, ?string $store = null): Driver
    {
        $store = $store ?: $this->getDefaultDriver();

        return $this->stores[$name] = $this->cached($name);
    }

    /**
     * Create an instance of the array driver.
     *
     * @param  string  $name
     * @return ArrayDriver
     */
    public function createArrayDriver($name)
    {
        return new ArrayDriver($name);
    }

    /**
     * Create an instance of the database driver.
     *
     * @param  string  $name
     * @return DatabaseDriver
     */
    public function createCookieDriver($name)
    {
        return new CookieDriver($name);
    }

    /**
     * Create an instance of the database driver.
     *
     * @param  string  $name
     * @return DatabaseDriver
     */
    public function createSessionDriver($name)
    {
        return new SessionDriver($name);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
        return $this->container['config']->get('persist.driver', SessionDriver::NAME);
    }

    /**
     * Set the default driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
        $this->container['config']->set('persist.driver', $name);
    }

    /**
     * Unset the given store instances.
     *
     * @param  string|array<int, string>|null  $name
     * @return $this
     */
    public function forgetDriver($name = null)
    {
        $name ??= $this->getDefaultDriver();

        foreach ((array) $name as $storeName) {
            if (isset($this->stores[$storeName])) {
                unset($this->stores[$storeName]);
            }
        }

        return $this;
    }

    /**
     * Forget all of the resolved store instances.
     *
     * @return $this
     */
    public function forgetDrivers()
    {
        $this->stores = [];

        return $this;
    }

    /**
     * Register a custom driver creator closure.
     *
     * @param  string  $driver
     * @param  Closure(string, Container): Contracts\Driver  $callback
     * @return $this
     */
    public function extend($driver, $callback)
    {
        $this->customCreators[$driver] = $callback->bindTo($this, $this);

        return $this;
    }

    /**
     * Attempt to get the store from the local cache.
     *
     * @param  string  $name
     * @return Driver
     *
     * @throws InvalidArgumentException
     */
    protected function cached($name)
    {
        return $this->stores[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve a view store instance.
     *
     * @param  string  $name
     * @return Driver
     *
     * @throws InvalidArgumentException
     */
    protected function resolve($name)
    {
        if (isset($this->customCreators[$name])) {
            $driver = $this->callCustomCreator($name);
        } else {
            $method = 'create'.ucfirst($name).'Driver';

            if (method_exists($this, $method)) {
                /** @var Contracts\Driver */
                $driver = $this->{$method}($name);
            } else {
                throw new InvalidArgumentException(
                    "Driver [{$name}] not supported."
                );
            }
        }

        return new Driver(
            $name,
            $driver
        );
    }

    /**
     * Call a custom driver creator.
     *
     * @param  string  $name
     * @return Contracts\Driver
     */
    protected function callCustomCreator($name)
    {
        return $this->customCreators[$name]($name, $this->container);
    }
}
