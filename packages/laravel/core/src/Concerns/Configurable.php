<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Honed\Core\Primitive;
use Honed\Core\PrimitiveManager;

/**
 * @phpstan-require-extends \Honed\Core\Primitive
 */
trait Configurable
{
    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp() { }

    /**
     * Set the configuration for the instance.
     *
     * @param  (Closure(static):static|void)  $configuration
     * @return void
     */
    public static function configureUsing($configuration)
    {
        PrimitiveManager::resolve()->configureUsing(
            static::class,
            $configuration,
        );
    }

    /**
     * Configure the instance.
     *
     * @return void
     */
    protected function configure()
    {
        PrimitiveManager::resolve()->configure(
            $this,
            $this->setUp(...),
        );
    }
}
