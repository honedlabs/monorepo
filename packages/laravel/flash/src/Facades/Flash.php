<?php

declare(strict_types=1);

namespace Honed\Flash\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Flash\Flash
 */
class Flash extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Flash\Flash::class;
    }
}