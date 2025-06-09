<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait Configurable
{
    /**
     * The configuration callback for the instance.
     * 
     * @var (\Closure(\Honed\Core\Primitive):\Honed\Core\Primitive|void)|null
     */
    protected static $configuration;

    /**
     * Set the configuration for the instance.
     * 
     * @param (\Closure(\Honed\Core\Primitive):\Honed\Core\Primitive|void) $configuration
     * @return void
     */
    public static function configureUsing($configuration)
    {
        static::$configuration = $configuration;
    }

    /**
     * Configure the instance.
     * 
     * @return void
     */
    public function configure()
    {
        if (static::$configuration) {
            static::$configuration($this);
        }
    }

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    public function setUp()
    {
        $this->configure();
    }
}