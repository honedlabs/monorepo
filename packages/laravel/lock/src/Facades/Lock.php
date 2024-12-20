<?php

declare(strict_types=1);

namespace Honed\Lock\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Lock\Lock
 */
class Lock extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Lock\Lock::class;
    }
}