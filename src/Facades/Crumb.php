<?php

namespace Honed\Crumb\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Crumb\Crumb
 */
class Crumb extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Crumb\Crumb::class;
    }
}
