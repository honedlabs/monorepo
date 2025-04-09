<?php

declare(strict_types=1);

namespace Honed\Typescript\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Typescript\Typescript
 */
class Typescript extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Typescript\Typescript::class;
    }
}