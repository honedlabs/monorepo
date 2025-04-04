<?php

declare(strict_types=1);

namespace Honed\Static\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Static\Static
 */
class Static extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Static\Static::class;
    }
}