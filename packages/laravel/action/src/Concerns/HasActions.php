<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

use Honed\Action\Action;
use Honed\Action\ActionGroup;
use Honed\Core\Parameters;
use Illuminate\Support\Arr;

use function array_filter;
use function array_map;
use function array_merge;
use function array_values;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @phpstan-require-extends \Honed\Core\Primitive
 */
trait HandlesActions
{
    /**
     * Whether the actions should be provided.
     * 
     * @var bool
     */
    protected $actionable = true;
    
    /**
     * Whether the instance should provide inline actions.
     *
     * @var bool
     */
    protected $inline = true;

    /**
     * Whether the instance should provide bulk actions.
     *
     * @var bool
     */
    protected $bulk = true;

    /**
     * Whether the instance should provide page actions.
     *
     * @var bool
     */
    protected $page = true;

    /**
     * List of the actions.
     *
     * @var array<int,Action|ActionGroup<TModel, TBuilder>>
     */
    protected $actions = [];

    /**
     * Set whether the actions should be provided.
     *
     * @param  bool  $provide
     * @return $this
     */
    public function actionable($provide = true)
    {
        $this->actionable = $provide;

        return $this;
    }

    /**
     * Set whether the actions should not be provided.
     * 
     * @param  bool  $provide
     * @return $this
     */
    public function notActionable($provide = true)
    {
        return $this->actionable(! $provide);
    }

    /**
     * Determine if the actions should be provided.
     *
     * @return bool
     */
    public function isActionable()
    {
        return $this->actionable;
    }

    /**
     * Determine if the actions should not be provided.
     *
     * @return bool
     */
    public function isNotActionable()
    {
        return ! $this->isActionable();
    }

    /**
     * Merge a set of actions with the existing actions.
     *
     * @param  Action|ActionGroup<TModel, TBuilder>|iterable<int, Action|ActionGroup<TModel, TBuilder>>  ...$actions
     * @return $this
     */
    public function actions(...$actions)
    {
        /** @var array<int, Action> */
        $actions = Arr::flatten($actions);

        $this->actions = array_merge($this->actions, $actions);

        return $this;
    }

    /**
     * Retrieve the actions
     *
     * @return array<int,Action>
     */
    public function getActions()
    {
        return array_merge(
            [],
            ...array_map(
                static fn ($action) => $action instanceof ActionGroup
                    ? $action->getActions()
                    : [$action],
                $this->actions
            )
        );
    }

    /**
     * 
     */
    public function inlineActions($actions)
    {
        dd(func_get_args());
    }

    /**
     * Retrieve only the allowed inline actions.
     *
     * @return array<int,Action>
     */
    public function getInlineActions()
    {
        if ($this->isNotInlinable()) {
            return [];
        }

        return array_values(
            array_filter(
                $this->getActions(),
                static fn (Action $action) => $action->isInline()
            )
        );
    }

    /**
     * Retrieve only the allowed bulk actions.
     *
     * @return array<int,Action>
     */
    public function getBulkActions()
    {
        if ($this->isNotBulkable()) {
            return [];
        }

        return array_values(
            array_filter(
                $this->getActions(),
                static fn (Action $action) => $action->isBulk() &&
                    $action->isAllowed()
            )
        );
    }

    /**
     * Retrieve only the allowed page actions.
     *
     * @return array<int,Action>
     */
    public function getPageActions()
    {
        if ($this->isNotPageable()) {
            return [];
        }

        return array_values(
            array_filter(
                $this->getActions(),
                static fn (Action $action) => $action->isPage() &&
                    $action->isAllowed()
            )
        );
    }

    /**
     * Get the inline actions as an array.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $model
     * @return array<int,mixed>
     */
    public function inlineActionsToArray($model = null)
    {
        $named = $typed = [];

        if ($model) {
            [$named, $typed] = Parameters::model($model);
        }

        return array_map(
            static fn (Action $action) => $action
                ->toArray($named, $typed),
            array_values(
                array_filter(
                    $this->getInlineActions(),
                    static fn (Action $action) => $action->isAllowed($named, $typed)
                )
            )
        );
    }

    /**
     * Get the bulk actions as an array.
     *
     * @return array<int,mixed>
     */
    public function bulkActionsToArray()
    {
        return array_map(
            static fn (Action $action) => $action->toArray(),
            $this->getBulkActions()
        );
    }

    /**
     * Get the page actions as an array.
     *
     * @return array<int,mixed>
     */
    public function pageActionsToArray()
    {
        return array_map(
            static fn (Action $action) => $action->toArray(),
            $this->getPageActions()
        );
    }
}
