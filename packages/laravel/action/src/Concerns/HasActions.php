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
     * List of the actions.
     *
     * @var array<int,Action|ActionGroup<TModel, TBuilder>>
     */
    protected $actions = [];
    
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
     * @param  iterable<int, Action|ActionGroup<TModel, TBuilder>>  $actions
     * @return $this
     */
    public function actions($actions)
    {
        $this->actions = [...$this->actions, ...$actions];

        return $this;
    }

    /**
     * Retrieve the actions
     *
     * @return array<int,Action>
     */
    public function getActions()
    {
        $actions = [];
        
        foreach ($this->actions as $action) {
            if ($action instanceof ActionGroup) {
                $actions = [...$actions, ...$action->getActions()];
            } else {
                $actions[] = $action;
            }
        }
        
        return $actions;
    }

    /**
     * Set the inline actions for the instance, or update whether the instance should provide inline actions.
     *
     * @param  iterable<\Honed\Action\Action>|bool $actions
     * @return $this
     */
    public function inlineActions($actions)
    {
        if (is_bool($actions)) {
            $this->inline = $actions;
        } else {
            $this->actions($actions);
        }

        return $this;
    }

    /**
     * Determine if the instance should provide inline actions.
     *
     * @return bool
     */
    public function isInlinable()
    {
        return $this->inline;
    }

    /**
     * Determine if the instance should not provide inline actions.
     *
     * @return bool
     */
    public function isNotInlinable()
    {
        return ! $this->isInlinable();
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
     * Set the bulk actions for the instance, or update whether the instance should provide bulk actions.
     *
     * @param  iterable<\Honed\Action\Action>|bool $actions
     * @return $this
     */
    public function bulkActions($actions)
    {
        if (is_bool($actions)) {
            $this->bulk = $actions;
        } else {
            $this->actions($actions);
        }

        return $this;
    }

    /**
     * Determine if the instance should provide bulk actions.
     *
     * @return bool
     */
    public function isBulkable()
    {
        return $this->bulk;
    }

    /**
     * Determine if the instance should not provide bulk actions.
     *
     * @return bool
     */
    public function isNotBulkable()
    {
        return ! $this->isBulkable();
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
     * Set the page actions for the instance, or update whether the instance should provide page actions.
     *
     * @param  iterable<\Honed\Action\Action>|bool $actions
     * @return $this
     */
    public function pageActions($actions)
    {
        if (is_bool($actions)) {
            $this->page = $actions;
        } else {
            $this->actions($actions);
        }

        return $this;
    }

    /**
     * Determine if the instance should provide page actions.
     *
     * @return bool
     */
    public function isPageable()
    {
        return $this->page;
    }

    /**
     * Determine if the instance should not provide page actions.
     *
     * @return bool
     */
    public function isNotPageable()
    {
        return ! $this->isPageable();
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
