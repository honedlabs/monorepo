<?php

declare(strict_types=1);

namespace Honed\Data\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Data\Data
 */
class Data extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Data\Data::class;
    }
}