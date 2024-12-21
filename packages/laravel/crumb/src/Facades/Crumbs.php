<?php

namespace Honed\Crumb\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Crumb\Manager
 */
class Crumbs extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Crumb\Manager::class;
    }
}
