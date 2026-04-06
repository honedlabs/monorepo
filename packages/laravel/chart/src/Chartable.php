<?php

declare(strict_types=1);

namespace Honed\Chart;

use Closure;
use Honed\Chart\Support\HigherOrderProxy;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;
use Illuminate\Support\Traits\ForwardsCalls;

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

