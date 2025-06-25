<?php

declare(strict_types=1);

namespace Honed\Core;

use Closure;
use Honed\Core\Contracts\ScopedPrimitiveManager;

class PrimitiveManager implements ScopedPrimitiveManager
{
    /**
     * The configurations for the primitive.
     *
     * @var array<class-string, array<int, Closure>>
     */
    protected $configurations = [];

    final public function __construct() {}

    /**
     * Resolve the scoped primitive manager.
     */
    public static function resolve(): static
    {
        if (app()->resolved(ScopedPrimitiveManager::class)) {
            return static::resolveScoped();
        }

        app()->singletonIf(
            static::class,
            fn () => new PrimitiveManager(),
        );

        return app(static::class);
    }

    /**
     * Get the already resolved scoped primitive manager.
     */
    public static function resolveScoped(): static
    {
        /** @phpstan-ignore-next-line */
        return app(ScopedPrimitiveManager::class);
    }

    /**
     * Configure the primitive using a closure.
     *
     * @param  class-string  $primitive
     */
    public function configureUsing(string $primitive, Closure $modifyUsing): void
    {
        $this->configurations[$primitive] ??= [];
        $this->configurations[$primitive][] = $modifyUsing;
    }

    /**
     * Configure the primitive
     */
    public function configure(Primitive $primitive, Closure $setUp): void
    {
        foreach ($this->configurations as $configurable => $callbacks) {
            if (! $primitive instanceof $configurable) {
                continue;
            }

            foreach ($callbacks as $configure) {
                $configure($primitive);
            }
        }

        $setUp();
    }

    /**
     * Clone the primitive manager.
     */
    public function clone(): static
    {
        return clone $this;
    }
}
