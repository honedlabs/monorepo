<?php

declare(strict_types=1);

namespace Honed\Registry\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Registry\Registry
 */
class Registry extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Registry\Registry::class;
    }
}