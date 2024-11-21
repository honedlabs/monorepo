<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Configurable
{
    protected static array $configurations = [];

    /**
     * Provide the class with any necessary setup.
     */
    public function setUp()
    {
        
    }

    /**
     * Configure the class using a callback.
     */
    public static function configureUsing(\Closure $callback): void
    {
        static::$configurations[static::class] ??= [];
        static::$configurations[static::class][] = $callback;
    }

    /**
     * Configure the class.
     * 
     * @return $this
     */
    public function configure(): static
    {
        $this->setUp();

        foreach (static::$configurations as $classToConfigure => $configurationCallbacks) {
            if (! $this instanceof $classToConfigure) {
                continue;
            }

            foreach ($configurationCallbacks as $configure) {
                $configure($this);
            }
        }

        return $this;
    }
}
