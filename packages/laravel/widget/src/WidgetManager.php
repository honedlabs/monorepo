<?php

namespace Honed\Widget;

use Closure;
use Honed\Widget\Contracts\Driver;
use Honed\Widget\Contracts\SerializesScope;
use Honed\Widget\Drivers\Decorator;
use Honed\Widget\Drivers\ArrayDriver;
use Honed\Widget\Drivers\DatabaseDriver;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Cookie\CookieJar;

/**
 * @mixin \Honed\Widget\Drivers\Decorator
 */
class WidgetManager
{
    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * The array of resolved Widget drivers.
     * 
     * @var array<string, \Honed\Widget\Drivers\Decorator>
     */
    protected $stores = [];

    /**
     * The registered custom drivers.
     *
     * @var array<string, \Closure(\Illuminate\Contracts\Container\Container, array<string, mixed>):mixed>
     */
    protected $customCreators = [];

    /**
     * The default scope resolver.
     * 
     * @var (callable(string):mixed)|null
     */
    protected $defaultScopeResolver;

    /**
     * Whether the Eloquent "morph map" should be used when serializing
     * the widget.
     * 
     * @var bool
     */
    protected $useMorphMap = false;

    /**
     * Create a new Widget manager instance.
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
     * Get a widget store instance.
     * 
     * @throws \InvalidArgumentException
     */
    public function store(?string $store = null): Decorator
    {
        return $this->driver($store);
    }

    /**
     * Get a widget store instance by name.
     *
     * @throws \InvalidArgumentException
     */
    public function driver(?string $name = null): Decorator
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->stores[$name] = $this->cached($name);
    }

    /**
     * Attempt to get the driver from the local cache.
     *
     * @param  string  $name
     * @return \Honed\Widget\Drivers\Decorator
     * 
     * @throws \Honed\Widget\Exceptions\UndefinedDriverException
     * @throws \Honed\Widget\Exceptions\InvalidDriverException
     */
    public function get($name)
    {
        return $this->drivers[$name] ?? $this->resolve($name);
    }

    /**
     * Create an instance of the array driver.
     */
    public function createArrayDriver(string $name): ArrayDriver
    {
        return new ArrayDriver(
            $this->getDispatcher(), $name
        );
    }

    // /**
    //  * Create an instance of the cache driver.
    //  * 
    //  * @return \Honed\Widget\Drivers\CacheDriver
    //  */
    // public function createCacheDriver()
    // {
    //     /** @var \Illuminate\Cache\CacheManager */
    //     $cache = $this->container->get('cache');

    //     /** @var \Illuminate\Contracts\Events\Dispatcher */
    //     $events = $this->container->get('events');

    //     /** @var \Illuminate\Contracts\Config\Repository */
    //     $config = $this->container->get('config');

    //     return new CacheDriver($cache, $events, $config);
    // }
    
    // /**
    //  * Create an instance of the cookie driver.
    //  * 
    //  * @return \Honed\Widget\Drivers\CookieDriver
    //  */
    // public function createCookieDriver()
    // {
    //     /** @var \Illuminate\Cookie\CookieJar */
    //     $cookies = $this->container->get('cookie');

    //     /** @var \Illuminate\Contracts\Events\Dispatcher */
    //     $events = $this->container->get('events');

    //     /** @var \Illuminate\Contracts\Config\Repository */
    //     $config = $this->container->get('config');

    //     return new CookieDriver($cookies, $events, $config);
    // }

    /**
     * Create an instance of the database driver.
     */
    public function createDatabaseDriver(string $name): DatabaseDriver
    {
        return new DatabaseDriver(
            $this->getDatabaseManager(), $this->getDispatcher(), $name,
        );
    }

    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string
    {
        // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
        return $this->container['config']->get('widget.default', 'database');
    }

    /**
     * Set the default driver name.
     */
    public function setDefaultDriver(string $name): void
    {
        // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
        $this->container['config']->set('widget.default', $name);
    }

    /**
     * Unset the given store instances.
     *
     * @param  string|array<int, string>|null  $name
     * @return $this
     */
    public function forgetDriver(string|array|null $name = null): static
    {
        $name ??= $this->getDefaultDriver();

        foreach ((array) $name as $driverName) {
            if (isset($this->stores[$driverName])) {
                unset($this->stores[$driverName]);
            }
        }

        return $this;
    }

    /**
     * Forget all of the resolved store instances.
     *
     * @return $this
     */
    public function forgetDrivers(): static
    {
        $this->stores = [];

        return $this;
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param  \Closure(\Illuminate\Contracts\Container\Container, array<string, mixed>):mixed  $callback
     * @return $this
     */
    public function extend(string $driver, Closure $callback): static
    {
        $this->customCreators[$driver] = $callback->bindTo($this, $this);

        return $this;
    }

    /**
     * Serialize the given scope for storage.
     *
     * @param  mixed  $scope
     * @return string
     * 
     * @throws \RuntimeException
     */
    public function serializeScope(mixed $scope): string
    {
        return match (true) {
            $scope instanceof SerializesScope => $scope->serializeScope(),
            is_string($scope) => $scope,
            is_numeric($scope) => (string) $scope,
            $scope instanceof Model && $this->useMorphMap => $scope->getMorphClass().'|'.$scope->getKey(), // @phpstan-ignore binaryOp.invalid
            $scope instanceof Model && ! $this->useMorphMap => $scope::class.'|'.$scope->getKey(), // @phpstan-ignore binaryOp.invalid
            default => throw new RuntimeException(
                'Unable to serialize the scope to a string. You should implement the ['.SerializesScope::class.'] contract.'
            )
        };
    }

    /**
     * Specify that the Eloquent morph map should be used when serializing.
     *
     * @return $this
     */
    public function useMorphMap(bool $value = true): static
    {
        $this->useMorphMap = $value;

        return $this;
    }

    /**
     * Determine if the Eloquent morph map should be used when serializing.
     */
    public function usesMorphMap(): bool
    {
        return $this->useMorphMap;
    }

    /**
     * Set the default scope resolver.
     *
     * @param  (callable(): mixed)  $resolver
     */
    public function resolveScopeUsing(callable $resolver): void
    {
        $this->defaultScopeResolver = $resolver;
    }

    /**
     * The default scope resolver.
     *
     * @return callable(): mixed
     */
    public function defaultScopeResolver(string $driver): callable
    {
        return function () use ($driver) {
            if ($this->defaultScopeResolver !== null) {
                return ($this->defaultScopeResolver)($driver);
            }

            // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
            return $this->container['auth']->guard()->user();
        };
    }

    /**
     * Resolve the given driver.
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve(string $name): Decorator
    {
        if (isset($this->customCreators[$name])) {
            $driver = $this->callCustomCreator($name);
        } else {
            $method = 'create'.ucfirst($name).'Driver';

            if (method_exists($this, $method)) {
                /** @var Driver */
                $driver = $this->{$method}($name);
            } else {
                throw new InvalidArgumentException(
                    "Driver [{$name}] not supported."
                );
            }
        }

        return new Decorator(
            $name,
            $driver,
            $this->defaultScopeResolver($name),
            $this->container,
        );
    }

    /**
     * Call a custom driver creator.
     */
    protected function callCustomCreator(string $name): Driver
    {
        return $this->customCreators[$name]($name, $this->container);
    }

    /**
     * Get the database manager instance from the container.
     */
    protected function getDatabaseManager(): DatabaseManager
    {
        /** @var DatabaseManager */
        return $this->container['db']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the event dispatcher instance from the container.
     */
    protected function getDispatcher(): Dispatcher
    {
        /** @var Dispatcher */
        return $this->container['events']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the cookie jar instance from the container.
     */
    protected function getCookieJar(): CookieJar
    {
        /** @var CookieJar */
        return $this->container['cookie']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the request instance from the container.
     */
    protected function getRequest(): Request
    {
        /** @var Request */
        return $this->request ??
            $this->container['request']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the session manager instance from the container.
     */
    protected function getSession(): SessionManager
    {
        /** @var SessionManager */
        return $this->session ??
            $this->container['session']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }
}