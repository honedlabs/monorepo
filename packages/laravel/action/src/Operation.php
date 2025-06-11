<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\BulkAction;
use Honed\Action\InlineAction;
use Honed\Action\PageAction;

abstract class Operation
{
    /**
     * Get the name of the menu option.
     * 
     * @return string
     */
    abstract protected static function name();

    /**
     * Get the label of the menu option.
     * 
     * @return string|\Closure
     */
    abstract protected static function label();

    /**
     * Get the icon of the menu option.
     * 
     * @return string|\BackedEnum|\Closure|null
     */
    protected static function icon()
    {
        return null;
    }

    /**
     * The type of the action to be generated.
     * 
     * @param class-string<\Honed\Action\Action> $type
     * 
     * @return \Honed\Action\Action
     */
    public static function create($type)
    {
        return $type::make(static::name(), static::label())
            ->icon(static::icon());
    }

    /**
     * Get as an inline action
     * 
     * @return \Honed\Action\InlineAction
     */
    public static function inline()
    {
        return static::create(InlineAction::class);
    }

    /**
     * Get as a bulk action
     * 
     * @return \Honed\Action\BulkAction
     */
    public static function bulk()
    {
        return static::create(BulkAction::class);
    }

    /**
     * Get as a page action
     * 
     * @return \Honed\Action\PageAction
     */
    public static function page()
    {
        return static::create(PageAction::class);
    }
}