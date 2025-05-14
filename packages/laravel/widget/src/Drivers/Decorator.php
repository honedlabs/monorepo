<?php

declare(strict_types=1);

namespace Honed\Widget\Drivers;

use Honed\Widget\Contracts\Driver;
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

    }

    public function set(string $widget, string $scope, mixed $value): void
    {

    }

    public function delete(string $widget, string $scope): void
    {

    }

    public function name($widget)
    {

    }

    public function instance($name)
    {

    }

    public function getDriver()
    {

    }
}