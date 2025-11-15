<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use Honed\Scaffold\Contracts\Property as PropertyContract;

abstract class Property implements PropertyContract
{
    /**
     * Whether the property is nullable.
     * 
     * @var bool
     */
    protected $nullable = false;

    /**
     * The default value of the property.
     * 
     * @var scalar
     */
    protected $default;

    /**
     * Create a new property instance.
     */
    public static function make(): static
    {
        return app(static::class);
    }
}