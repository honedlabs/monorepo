<?php

declare(strict_types=1);

namespace Honed\Chart\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Chart\Chart
 */
class Chart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Chart\Chart::class;
    }
}