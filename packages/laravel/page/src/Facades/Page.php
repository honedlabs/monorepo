<?php

declare(strict_types=1);

namespace Honed\Page\Facades;

use Honed\Page\PageRouter;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Page\PageRouter
 */
class Page extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PageRouter::class;
    }
}
