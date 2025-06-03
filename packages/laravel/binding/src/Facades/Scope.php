<?php

declare(strict_types=1);

namespace Honed\Binding\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Binding\Binding
 */
class Binding extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Binding\Binding::class;
    }
}