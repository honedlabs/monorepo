<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

/**
 * @phpstan-require-extends \Honed\Core\Primitive
 */
trait Configurable
{
    /**
     * The configuration callback for the instance.
     *
     * @var (Closure(static):static|void)|null
     */
    protected static $configuration;

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->configure();
    }

    /**
     * Set the configuration for the instance.
     *
     * @param  (Closure(static):static|void)  $configuration
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
    protected function configure()
    {
        if (isset(static::$configuration)) {
            $configuration = static::$configuration;

            $configuration($this); // @phpstan-ignore callable.nonCallable
        }
    }
}
