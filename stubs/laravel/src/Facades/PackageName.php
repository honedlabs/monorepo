<?php

declare(strict_types=1);

namespace VendorName\PackageName\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VendorName\PackageName\PackageName
 */
class PackageName extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \VendorName\PackageName\PackageName::class;
    }
}