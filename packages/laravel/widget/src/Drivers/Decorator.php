<?php

namespace Honed\Widget\Drivers;

use RuntimeException;
use Honed\Widget\Widget;
use Honed\Widget\Contracts\Driver;
use Illuminate\Support\Facades\Event;
use Honed\Widget\Events\WidgetDeleted;
use Honed\Widget\Events\WidgetUpdated;
use Honed\Widget\ScopedWidgetRetrieval;
use Illuminate\Support\Traits\Macroable;
use Honed\Widget\Contracts\CanListWidgets;
use Honed\Widget\Contracts\WidgetScopeable;
use Illuminate\Contracts\Container\Container;

class Decorator implements Driver
{
    use Macroable {
        __call as macroCall;
    }

    /**
     * The store's name.
     *
     * @var string
     */
    protected $name;

    /**
     * The driver instance.
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
     * @param (callable():mixed) $defaultScopeResolver
     */
    public function __construct(
        string $name,
        Driver $driver,
        callable $defaultScopeResolver,
        Container $container
    ) {
        $this->name = $name;
        $this->driver = $driver;
        $this->defaultScopeResolver = $defaultScopeResolver;
        $this->container = $container;
    }

    /**
     * Dynamically call the underlying driver instance.
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

        return tap(new ScopedWidgetRetrieval($this), function ($retrieval) use ($name) {
            if ($name !== 'for' && ($scope = ($this->defaultScopeResolver)()) !== null) {
                $retrieval->for($scope);
            }
        })->{$name}(...$parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function get($scope, $group = null)
    {
        $this->driver->get($scope, $group);

        // Event::dispatch(new WidgetRetrieved($widget, $scope, $item));

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function set($widget, $scope, $group = null, $order = 0)
    {
        $widget = $this->resolveWidget($widget);

        $scope = $this->resolveScope($scope);

        $this->driver->set($widget, $scope, $group, $order);

        Event::dispatch(new WidgetUpdated($widget, $scope));
    }

    /**
     * {@inheritdoc}
     */
    public function update($widget, $scope, $group = null, $order = 0)
    {
        $widget = $this->resolveWidget($widget);

        $scope = $this->resolveScope($scope);

        $outcome = $this->driver->update($widget, $scope, $group, $order);

        Event::dispatch(new WidgetUpdated($widget, $scope, $group, $order));
        
        return $outcome;

    }

    /**
     * {@inheritdoc}
     */
    public function delete($widget, $scope, $group = null)
    {
        $widget = $this->resolveWidget($widget);

        $scope = $this->resolveScope($scope);

        $this->driver->delete($widget, $scope, $group);

        Event::dispatch(new WidgetDeleted($widget, $scope));
    }

    /**
     * {@inheritdoc}
     */
    public function exists($widget, $scope, $group = null)
    {
        $widget = $this->resolveWidget($widget);

        $scope = $this->resolveScope($scope);
    }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function purge(...$widgets)
    // {
    //     $this->driver->purge(...$widgets);
    // 

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
     * Resolve the widget by name.
     * 
     * @param string $widget
     * @return string
     */
    protected function resolveWidget(string $widget): string
    {
        if (class_exists($widget)
            && is_subclass_of($widget, Widget::class)
            && $name = $this->container->make($widget)->getName()
        ) {
            return $name;
        }

        return $widget;
    }

    /**
     * Retrieve the widget's class.
     * 
     * @param string $name
     * @return \Honed\Widget\Contracts\Widget
     */
    public function instance($name)
    {
        $widget = $this->implementationClass($name);

        // if (is_string($widget) && class_exists($widget)) {
            // return $this->container->make($widget);
        // }

        return fn () => $widget;
    }

    /**
     * Resolve the scope.
     *
     * @param  mixed  $scope
     * @return mixed
     */
    protected function resolveScope($scope)
    {
        return $scope instanceof WidgetScopeable
            ? $scope->toWidgetIdentifier($this->name)
            : $scope;
    }

    /**
     * Get the underlying driver instance.
     */
    public function getDriver(): Driver
    {
        return $this->driver;
    }


    /**
     * Set the container instance used by the decorator.
     *
     * @return $this
     */
    public function setContainer(Container $container): static
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Retrieve the default scope.
     */
    protected function defaultScope(): mixed
    {
        return ($this->defaultScopeResolver)();
    }

    /**
     * Check if the driver supports listing widgets.
     *
     * @throws RuntimeException
     */
    protected function checkIfCanListWidgets(): CanListWidgets
    {
        if (! $this->driver instanceof CanListWidgets) {
            throw new RuntimeException(
                "The [{$this->name}] driver does not support listing widgets."
            );
        }

        /** @var CanListViews */
        return $this->driver;
    }
}