<?php

declare(strict_types=1);

namespace Honed\Refining\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Refining\Refining
 */
class Refining extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Refining\Refining::class;
    }
}