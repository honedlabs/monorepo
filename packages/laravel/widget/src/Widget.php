<?php

declare(strict_types=1);

namespace Honed\Widget;

abstract class Widget
{
    /**
     * The unique name of the widget across your application's widgets.
     * 
     * @var string|null
     */
    protected $name;

    public function getName()
    {
        return null;
    }

    // scope

    // isStatic

    // Retrieval

    //

    public static function register()
    {
        //
    }
    
}