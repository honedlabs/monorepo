<?php

declare(strict_types=1);

namespace Honed\Widget\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Widget\Widget
 */
class Widget extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Widget\Widget::class;
    }
}