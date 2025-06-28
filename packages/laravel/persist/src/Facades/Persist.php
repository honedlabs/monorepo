<?php

declare(strict_types=1);

namespace Honed\Persist\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Persist\Persist
 */
class Persist extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Persist\Persist::class;
    }
}