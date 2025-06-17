<?php

declare(strict_types=1);

namespace Honed\Action;

abstract class Assembler
{
    /**
     * Configure the action.
     * 
     * @param  Action  $action
     * @return Action
     */
    abstract protected function definition(Action $action): Action;

    /**
     * Get as an inline action
     *
     * @return InlineAction
     */
    public static function inline(): InlineAction
    {
        return static::create(InlineAction::class);
    }

    /**
     * Get as a bulk action
     *
     * @return BulkAction
     */
    public static function bulk(): BulkAction
    {
        return static::create(BulkAction::class);
    }

    /**
     * Get as a page action
     *
     * @return PageAction
     */
    public static function page(): PageAction
    {
        return static::create(PageAction::class);
    }

    /**
     * The type of the action to be generated.
     *
     * @param  class-string<Action>  $type
     * @return Action
     */
    protected static function create(string $type): Action
    {
        return resolve(static::class)->definition(new $type());
    }
}
