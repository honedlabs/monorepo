<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

abstract class Chartable extends Primitive implements NullsAsUndefined
{
    /**
     * Create a new instance of the class.
     */
    public static function make(): static
    {
        return app(static::class);
    }
}
