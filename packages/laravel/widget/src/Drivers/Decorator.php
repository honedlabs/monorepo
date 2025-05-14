<?php

declare(strict_types=1);

namespace Honed\Widget\Drivers;

use Honed\Widget\Contracts\Driver;
use Honed\Widget\Events\WidgetDeleted;
use Honed\Widget\Events\WidgetUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Traits\Macroable;

class Decorator implements Driver
{
    use Macroable {
        __call as macroCall;
    }

    /**
     * The driver name.
     *
     * @var string
     */
    protected $name;

    /**
     * The driver being decorated.
     *
     * @var \Honed\Widget\Contracts\Driver
     */
    protected $driver;


    /**
     * The default scope resolver.
     *
     * @var callable(): mixed
     */
    protected $defaultScopeResolver;

    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * Create a new driver decorator instance.
     * 
     * @param string $name
     * @param \Honed\Widget\Contracts\Driver $driver
     * @param (callable():mixed)|null $defaultScopeResolver
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(
        $name,
        $driver,
        $defaultScopeResolver,
        $container
    ) {
        $this->name = $name;
        $this->driver = $driver;
        $this->defaultScopeResolver = $defaultScopeResolver;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $widget, string $scope): mixed
    {
        $widget = $this->resolveWidget($widget);

        $scope = $this->resolveScope($scope);

        $item = null;

        // Event::dispatch(new WidgetRetrieved($widget, $scope, $item));

        return $item;
    }

    public function set(string $widget, string $scope, mixed $value): void
    {
        $widget = $this->resolveWidget($widget);

        $scope = $this->resolveScope($scope);

        $this->driver->set($widget, $scope, $value);

        Event::dispatch(new WidgetUpdated($widget, $scope));

    }

    public function delete(string $widget, string $scope): void
    {
        $widget = $this->resolveWidget($widget);

        $scope = $this->resolveScope($scope);

        $this->driver->delete($widget, $scope);

        Event::dispatch(new WidgetDeleted($widget, $scope));

    }

    /**
     * Retrieve the widget's name.
     * 
     * @param string $widget
     * @return string
     */
    public function name($widget)
    {
        return $this->resolveWidget($widget);
    }
    
    /**
     * Retrieve the widget's class.
     * 
     * @param string $name
     * @return \Honed\Widget\Contracts\Widget
     */
    public function instance($name)
    {
        $this->container->make($name);
    }

    /**
     * Get the underlying driver instance.
     * 
     * @return \Honed\Widget\Contracts\Driver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set the container instance used by the decorator.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @return $this
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }


    /**
     * Dynamically create a pending feature interaction.
     *
     * @param  string  $name
     * @param  array<mixed>  $parameters
     * @return mixed
     */
    public function __call($name, $parameters)
    {
        if (static::hasMacro($name)) {
            return $this->macroCall($name, $parameters);
        }

        // Forward to the driver
    }
}