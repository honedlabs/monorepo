<?php

use Honed\Crumb\Facades\Crumbs;

if (! \function_exists('crumbs')) {
    /**
     * Nav facade accessor
     *
     * @param string|
     * @return \Honed\Nav\Nav
     */
    function crumbs(...$items)
    {
        $instance = Crumbs::getFacadeRoot();

        return $instance;
    }
}
