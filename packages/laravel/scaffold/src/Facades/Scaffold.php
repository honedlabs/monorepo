<?php

declare(strict_types=1);

namespace Honed\Scaffold\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Scaffold\Scaffold
 */
class Scaffold extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Scaffold\Scaffold::class;
    }
}