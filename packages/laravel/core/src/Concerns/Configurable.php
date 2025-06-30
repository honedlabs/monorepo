<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Honed\Core\PrimitiveManager;

/**
 * @phpstan-require-extends \Honed\Core\Primitive
 */
trait Configurable
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        if (method_exists($this, 'definition')) {
            $this->definition($this);
        }
    }

    /**
     * Set the configuration for the instance.
     */
    public static function configureUsing(Closure $configuration): void
    {
        PrimitiveManager::resolve()->configureUsing(
            static::class,
            $configuration,
        );
    }

    /**
     * Configure the instance.
     */
    protected function configure(): void
    {
        PrimitiveManager::resolve()->configure(
            $this,
            $this->setUp(...),
        );
    }
}
