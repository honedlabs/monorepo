<?php

declare(strict_types=1);

namespace Honed\Billing;

use Closure;
use Honed\Billing\Contracts\Driver;
use Honed\Billing\Drivers\ConfigDriver;
use Honed\Billing\Drivers\DatabaseDriver;
use Honed\Billing\Drivers\Decorator;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\DatabaseManager;
use InvalidArgumentException;

/**
 * @mixin \Honed\Billing\Contracts\Driver
 */
class BillingManager
{
    /**
     * The container instance.
     *
     * @var Container
     */
    protected $container;

    /**
     * The array of resolved drivers.
     *
     * @var array<string, Decorator>
     */
    protected $drivers = [];

    /**
     * The registered custom driver creators.
     *
     * @var array<string, Closure(string, Container): Driver>
     */
    protected $customCreators = [];

    /**
     * The cache of retrieved products.
     *
     * @var array<string, Product|null>
     */
    protected $cache = [];

    /**
     * Create a new billing manager.
     *
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param  array<int, mixed>  $parameters
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->driver()->{$method}(...$parameters);
    }

    /**
     * Find a product by name.
     */
    public function find(mixed $product, ?string $name = null): ?Product
    {
        return $this->cache[$product] ??= $this->findByName($product, $name);
    }

    /**
     * Get a builder for the products.
     */
    public function query(): Decorator
    {
        return $this->driver();
    }

    /**
     * Get a driver instance by name.
     *
     * @throws InvalidArgumentException
     */
    public function driver(?string $name = null): Decorator
    {
        $name ??= $this->getDefaultDriver();

        return $this->drivers[$name] = $this->cached($name);
    }

    /**
     * Create an instance of the array driver.
     */
    public function createConfigDriver(string $name): ConfigDriver
    {
        return new ConfigDriver(
            $name, $this->getConfig()
        );
    }

    /**
     * Create an instance of the database driver.
     */
    public function createDatabaseDriver(string $name): DatabaseDriver
    {
        return new DatabaseDriver(
            $name, $this->getDatabaseManager()
        );
    }

    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string
    {
        // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
        return $this->container['config']->get('billing.default', 'config');
    }

    /**
     * Set the default driver name.
     */
    public function setDefaultDriver(string $name): void
    {
        // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
        $this->container['config']->set('billing.driver', $name);
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

        foreach ((array) $name as $storeName) {
            if (isset($this->stores[$storeName])) {
                unset($this->stores[$storeName]);
            }
        }

        return $this;
    }

    /**
     * Forget all of the resolved driver instances.
     *
     * @return $this
     */
    public function forgetDrivers(): static
    {
        $this->drivers = [];

        return $this;
    }

    /**
     * Register a custom driver creator closure.
     *
     * @param  Closure(string, Container): Driver  $callback
     * @return $this
     */
    public function extend(string $driver, Closure $callback): static
    {
        $this->customCreators[$driver] = $callback->bindTo($this, $this);

        return $this;
    }

    /**
     * Get a product by the name.
     */
    protected function findByName(mixed $product, ?string $name = null): ?Product
    {
        return $this->driver($name)
            ->whereProduct($product)
            ->first();
    }

    /**
     * Attempt to get the driver from the local cache.
     *
     * @throws InvalidArgumentException
     */
    protected function cached(string $name): Decorator
    {
        return $this->drivers[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve a driver.
     *
     * @throws InvalidArgumentException
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

        return new Decorator($name, $driver);
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
     * Get the config instance from the container.
     *
     * @return array<string, mixed>
     */
    protected function getConfig(): array
    {
        /** @var array<string, mixed> */
        return $this->container['config']['billing'] ?? []; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }
}
