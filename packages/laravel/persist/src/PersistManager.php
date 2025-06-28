<?php

declare(strict_types=1);

namespace Honed\Persist;

use Closure;
use Honed\Persist\Drivers\ArrayDriver;
use Honed\Persist\Drivers\SessionDriver;
use Honed\Persist\Drivers\CookieDriver;
use Honed\Persist\Drivers\Decorator;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use RuntimeException;

class ViewManager
{
    /**
     * The container instance.
     *
     * @var Container
     */
    protected $container;

    /**
     * The array of resolved view stores.
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
     * The default scope resolver.
     *
     * @var (callable(mixed...): mixed)|null
     */
    protected $defaultScopeResolver;

    /**
     * Indicates if the Eloquent "morph map" should be used when serializing.
     *
     * @var bool
     */
    protected $useMorphMap = false;

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
     * Dynamically call the default store instance.
     *
     * @param  string  $method
     * @param  array<int, mixed>  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->store()->{$method}(...$parameters);
    }

    /**
     * Get a view store instance.
     *
     * @param  string|null  $store
     * @return Decorator
     *
     * @throws InvalidArgumentException
     */
    public function store($store = null)
    {
        return $this->driver($store);
    }

    /**
     * Get a view store instance by name.
     *
     * @param  string|null  $name
     * @return Decorator
     *
     * @throws InvalidArgumentException
     */
    public function driver($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

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
    public function createSessionDriver($name)
    {
        return new SessionDriver($name);
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
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
        return $this->container['config']->get('persist.driver', 'session');
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
     * @return Decorator
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
     * @return Decorator
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

        return new Decorator(
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
