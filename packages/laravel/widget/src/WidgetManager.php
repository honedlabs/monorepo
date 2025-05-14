<?php

declare(strict_types=1);

namespace Honed\Widget;

use Honed\Widget\Drivers\ArrayDriver;
use Honed\Widget\Drivers\CacheDriver;
use Honed\Widget\Drivers\CookieDriver;
use Honed\Widget\Drivers\DatabaseDriver;
use Illuminate\Contracts\Container\Container;

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
    protected $drivers = [];

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
     * Get a Widget driver instance by name.
     * 
     * @param string|null $name
     * @return \Honed\Widget\Drivers\Decorator
     */
    public function driver($name = null)
    {
        $name = $name ?? $this->getDefaultDriver();

        return $this->drivers[$name] = $this->get($name);
    }

    /**
     * Attempt to get the driver from the local cache.
     *
     * @param  string  $name
     * @return \Honed\Widget\Drivers\Decorator
     */
    protected function get($name)
    {
        return $this->drivers[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given driver.
     *
     * @param  string  $name
     * @return \Honed\Widget\Drivers\Decorator
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Pennant store [{$name}] is not defined.");
        }

        if (isset($this->customCreators[$config['driver']])) {
            $driver = $this->callCustomCreator($config);
        } else {
            $driverMethod = 'create'.ucfirst($config['driver']).'Driver';

            if (method_exists($this, $driverMethod)) {
                $driver = $this->{$driverMethod}($config, $name);
            } else {
                throw new InvalidArgumentException("Driver [{$config['driver']}] is not supported.");
            }
        }

        return new Decorator(
            $name,
            $driver,
            $this->defaultScopeResolver($name),
            $this->container,
            new Collection
        );
    }

    /**
     * Create an instance of the array driver.
     *
     * @return \Honed\Widget\Drivers\ArrayDriver
     */
    public function createArrayDriver()
    {
        return new ArrayDriver($this->container['events'], []);
    }

    /**
     * Create an instance of the cache driver.
     * 
     * @return \Honed\Widget\Drivers\CacheDriver
     */
    public function createCacheDriver()
    {
        return new CacheDriver($this->container['cache'], $this->container['config']);
    }
    
    /**
     * Create an instance of the cookie driver.
     * 
     * @return \Honed\Widget\Drivers\CookieDriver
     */
    public function createCookieDriver()
    {
        return new CookieDriver($this->container['cookie'], $this->container['config']);
    }

    /**
     * Create an instance of the database driver.
     *
     * @param string $name
     * @return \Honed\Widget\Drivers\DatabaseDriver
     */
    public function createDatabaseDriver(array $config, $name)
    {
        return new DatabaseDriver(
            $this->container['db'],
            $this->container['events'],
            $this->container['config'],
            $name,
            []
        );
    }

    /**
     * Specify that the Eloquent morph map should be used when serializing.
     *
     * @param  bool  $value
     * @return $this
     */
    public function useMorphMap($value = true)
    {
        $this->useMorphMap = $value;

        return $this;
    }

    /**
     * Flush the driver caches.
     *
     * @return void
     */
    public function flushCache()
    {
        foreach ($this->drivers as $driver) {
            $driver->flushCache();
        }
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->container['config']->get('widget.default') ?? 'database';
    }

    /**
     * Set the default driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->container['config']->set('widget.default', $name);
    }

    /**
     * Get the driver configuration.
     *
     * @param string $name
     * @return array
     */
    public function getConfig($name)
    {
        return $this->container['config']["widget.drivers.{$name}"];
    }
}