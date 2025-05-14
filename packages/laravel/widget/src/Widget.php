<?php

declare(strict_types=1);

namespace Honed\Widget;

use Illuminate\Support\Str;

abstract class Widget
{
    /**
     * The unique name of the widget across your application's widgets.
     * 
     * @var string|null
     */
    protected $name;

    /**
     * The callback to guess the widget name.
     * 
     * @var (callable(static):string)|null
     */
    protected static $guessWidgetNameUsing;

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
        return $this->name 
            ?? $this->getName() 
            ?? $this->guessWidgetName();
    }

    /**
     * Guess the widget name.
     * 
     * @return string
     */
    public function guessWidgetName()
    {
        if (static::$guessWidgetNameUsing) {
            return call_user_func(static::$guessWidgetNameUsing, $this);
        }

        return Str::of(static::class)
            ->basename()
            ->kebab()
            ->value();
    }

    /**
     * Set the callback to guess the widget name.
     * 
     * @param callable(static):string $callback
     */
    public static function guessWidgetNameUsing($callback)
    {
        static::$guessWidgetNameUsing = $callback;
    }

    /**
     * Retrieve the value of the widget.
     * 
     * @return mixed
     */
    abstract public function getValue();

    //

    public static function register()
    {
        //
    }
    
}