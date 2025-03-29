<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\Concerns\HasActions;
use Honed\Action\Concerns\HasEncoder;
use Honed\Action\Concerns\HasEndpoint;
use Honed\Action\Concerns\HasRouteBindings;
use Honed\Core\Primitive;
use Illuminate\Contracts\Routing\UrlRoutable;

class ActionGroup extends Primitive implements UrlRoutable
{
    use HasActions;
    use HasEndpoint;
    use HasEncoder;
    /**
     * @use HasRouteBindings<static>
     */
    use HasRouteBindings;

    /**
     * Whether to execute server actions.
     *
     * @var bool
     */
    protected $execute = false;

    /**
     * Create a new action group instance.
     *
     * @param  \Honed\Action\Action  ...$actions
     * @return static
     */
    public static function make(...$actions)
    {
        return resolve(static::class)
            ->withActions($actions);
    }

    public function bindingClass()
    {
        return static::class;
    }

    public function getRouteKeyName()
    {
        return 'action';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if ($this->shouldExecute()) {
            return [
                'id' => $this->getRouteKey(),
                'endpoint' => $this->getEndpoint(),
                'actions' => $this->getActions(),
            ];
        }

        return [
            'actions' => $this->getActions(),
        ];
    }
}
