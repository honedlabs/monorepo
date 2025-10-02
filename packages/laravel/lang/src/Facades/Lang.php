<?php

declare(strict_types=1);

namespace Honed\Lang\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Lang\Lang
 */
class Lang extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Lang\Lang::class;
    }
}