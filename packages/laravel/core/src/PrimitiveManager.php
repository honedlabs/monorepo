<?php

namespace Honed\Core;

use Closure;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;
use Honed\Core\Primitive;
use Illuminate\Support\Facades\App;
use Honed\Core\Contracts\ScopedPrimitiveManager;

class PrimitiveManager implements ScopedPrimitiveManager
{
    /**
     * The configurations for the primitive.
     * 
     * @var array<class-string<\Honed\Core\Primitive>, array<int, (\Closure(\Honed\Core\Primitive):mixed|void)>>
     */
    protected $configurations = [];

    final public function __construct() {}

    /**
     * Resolve the scoped primitive manager.
     * 
     * @return static
     */
    public static function resolve(): static
    {
        if (app()->resolved(PrimitiveManager::class)) {
            return static::resolveScoped();
        }


        app()->singletonIf(
            PrimitiveManager::class,
            fn () => new PrimitiveManager,
        );

        return app(PrimitiveManager::class);
    }

    /**
     * Get the already resolved scoped primitive manager.
     * 
     * @return static
     */
    public static function resolveScoped(): static
    {
        return app(PrimitiveManager::class);
    }

    /**
     * Set the primitive's configuration.
     * 
     * @template T of \Honed\Core\Primitive
     * 
     * @param  class-string<T>  $component
     * @param  (\Closure(T):mixed|void)  $modifyUsing
     * @return void
     */
    public function configureUsing(string $component, Closure $modifyUsing): void
    {
        $this->configurations[$component] ??= [];
        $this->configurations[$component][] = $modifyUsing;
    }

    /**
     * Configure the primitive
     *
     * @param  \Honed\Core\Primitive  $primitive
     * @param  \Closure  $setUp
     * @return void
     */
    public function configure(Primitive $primitive, Closure $setUp): void
    {
        foreach ($this->configurations as $configurable => $configurationCallbacks) {
            if (! $primitive instanceof $configurable) {
                continue;
            }

            foreach ($configurationCallbacks as $configure) {
                $configure($primitive);
            }
        }

        $setUp();
    }

    /**
     * Clone the primitive manager.
     * 
     * @return static
     */
    public function clone(): static
    {
        return clone $this;
    }
}