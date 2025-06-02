<?php

declare(strict_types=1);

namespace Honed\Abn\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Abn\Abn
 */
class Abn extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Abn\Abn::class;
    }
}