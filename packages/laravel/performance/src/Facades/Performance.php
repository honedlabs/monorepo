<?php

declare(strict_types=1);

namespace Honed\Performance\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Performance\Performance
 */
class Performance extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Performance\Performance::class;
    }
}