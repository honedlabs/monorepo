<?php

declare(strict_types=1);

namespace Honed\Widget\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Widget\WidgetManager
 */
class Widgets extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Widget\WidgetManager::class;
    }
}