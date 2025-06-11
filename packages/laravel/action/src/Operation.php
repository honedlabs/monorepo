<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\BulkAction;
use Honed\Action\InlineAction;
use Honed\Action\PageAction;

abstract class Operation
{
    /**
     * Configure the action.
     * 
     * @param \Honed\Action\Action $action
     * 
     * @return \Honed\Action\Action
     */
    abstract protected function definition(Action $action): Action;

    /**
     * The type of the action to be generated.
     * 
     * @param class-string<\Honed\Action\Action> $type
     * 
     * @return \Honed\Action\Action
     */
    protected function create($type)
    {
        return static::definition(new $type);
    }

    /**
     * Get as an inline action
     * 
     * @return \Honed\Action\InlineAction
     */
    public static function inline()
    {
        return resolve(static::class)->create(InlineAction::class);
    }

    /**
     * Get as a bulk action
     * 
     * @return \Honed\Action\BulkAction
     */
    public static function bulk()
    {
        return resolve(static::class)->create(BulkAction::class);
    }

    /**
     * Get as a page action
     * 
     * @return \Honed\Action\PageAction
     */
    public static function page()
    {
        return resolve(static::class)->create(PageAction::class);
    }
}