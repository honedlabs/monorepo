<?php

declare(strict_types=1);

namespace Honed\List\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\List\List
 */
class List extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\List\List::class;
    }
}