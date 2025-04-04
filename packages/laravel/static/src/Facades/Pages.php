<?php

declare(strict_types=1);

namespace Honed\Pages\Facades;

use Honed\Pages\PageRouter;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Pages\PageRouter
 */
class Pages extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PageRouter::class;
    }
}