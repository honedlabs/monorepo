<?php

declare(strict_types=1);

namespace Honed\Widget;

use Honed\Widget\Drivers\ArrayDriver;
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
     * Create a new Widget manager instance.
     *
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
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