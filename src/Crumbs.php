<?php

namespace Honed\Crumb;


class Crumbs
{
    /** 
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    public function __construct()
    {

    }

    public static function for(string $name, \Closure $trail)
    {

    }

    /**
     * Determine if a crumb with the given name exists. 
     */
    public static function exists(string $name): bool
    {
        return isset($this->crumbs[$name]);
    }

}
