<?php

declare(strict_types=1);

namespace Honed\Lock\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Lock\Locker
 */
class Lock extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Lock\Locker::class;
    }
}