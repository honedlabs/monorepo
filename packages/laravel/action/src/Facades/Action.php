<?php

declare(strict_types=1);

namespace Honed\Action\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Action\Creator
 */
class Action extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Action\Creator::class;
    }
}