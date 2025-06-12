<?php

declare(strict_types=1);

namespace Honed\Action;

abstract class Operation
{
    /**
     * Configure the action.
     */
    abstract protected function definition(Action $action): Action;

    /**
     * Get as an inline action
     *
     * @return InlineAction
     */
    public static function inline()
    {
        return resolve(static::class)->create(InlineAction::class);
    }

    /**
     * Get as a bulk action
     *
     * @return BulkAction
     */
    public static function bulk()
    {
        return resolve(static::class)->create(BulkAction::class);
    }

    /**
     * Get as a page action
     *
     * @return PageAction
     */
    public static function page()
    {
        return resolve(static::class)->create(PageAction::class);
    }

    /**
     * The type of the action to be generated.
     *
     * @param  class-string<Action>  $type
     * @return Action
     */
    protected function create($type)
    {
        return static::definition(new $type());
    }
}
