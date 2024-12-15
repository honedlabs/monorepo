<?php

namespace Honed\Crumb;

class Trail 
{
    public function __construct(...$crumbs) 
    {

    }
    
    public static function make(...$crumbs): static
    {
        return resolve(static::class, ...$crumbs);
    }
}
