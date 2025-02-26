<?php

declare(strict_types=1);

namespace Honed\Upload\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Upload\Upload
 */
class Upload extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Upload\Upload::class;
    }
}
