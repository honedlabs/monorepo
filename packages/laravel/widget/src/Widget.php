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

    /**
     * Get the name of the widget to be used.
     * 
     * @return string|null
     */
    public function getName()
    {
        return null;
    }

    /**
     * Get the name of the widget to be used.
     * 
     * @return string
     */
    public function name()
    {
        return $this->name ?? $this->getName() ?? static::class;
    }

    // scope

    // isStatic

    // Retrieval

    public function getValue()
    {
        
    }

    //

    public static function register()
    {
        //
    }
    
}