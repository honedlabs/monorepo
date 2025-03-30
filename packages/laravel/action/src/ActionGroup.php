<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\Concerns\HasActions;
use Honed\Action\Concerns\HasEndpoint;
use Honed\Action\Concerns\HasRouteBinding;
use Honed\Core\Primitive;
use Illuminate\Contracts\Routing\UrlRoutable;

class ActionGroup extends Primitive implements UrlRoutable
{
    use HasActions;
    use HasEndpoint;
    /**
     * @use \Honed\Action\Concerns\HasRouteBinding<static>
     */
    use HasRouteBinding;

    /**
     * The model the inline actions should use to resolve.
     *
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    protected $for;

    /**
     * Whether to execute server actions.
     *
     * @var bool
     */
    protected $execute = false;

    /**
     * Create a new action group instance.
     *
     * @param  \Honed\Action\Action|iterable<int, \Honed\Action\Action>  ...$actions
     * @return static
     */
    public static function make(...$actions)
    {
        return resolve(static::class)
            ->withActions($actions);
    }

    /**
     * Get the primitive class for binding.
     *
     * @return class-string<\Honed\Action\ActionGroup>
     */
    public function primitive()
    {
        return ActionGroup::class;
    }

    /**
     * Get the route key for the class.
     * 
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'action';
    }

    /**
     * Set the model the inline actions should be bound to.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return $this
     */
    public function for($model)
    {
        $this->for = $model;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $actions = [
            'inline' => $this->inlineActionsToArray($this->for),
            'bulk' => $this->bulkActionsToArray(),
            'page' => $this->pageActionsToArray(),
        ];

        if ($this->shouldExecute()) {
            return \array_merge($actions, [
                'id' => $this->getRouteKey(),
                'endpoint' => $this->getEndpoint(),
            ]);
        }

        return $actions;
    }
}
