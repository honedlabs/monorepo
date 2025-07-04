<?php

declare(strict_types=1);

namespace Honed\Stats\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Stats\Stats
 */
class Stats extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Stats\Stats::class;
    }
}