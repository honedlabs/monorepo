<?php

declare(strict_types=1);

namespace Honed\Disable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Disable\Disable
 */
class Disable extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Disable\Disable::class;
    }
}