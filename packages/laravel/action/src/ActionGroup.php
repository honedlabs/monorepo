<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\Concerns\HasActions;
use Honed\Action\Concerns\HasEndpoint;
use Honed\Core\Primitive;

class ActionGroup extends Primitive
{
    use HasActions;
    use HasEndpoint;

    /**
     * Create a new action group instance.
     *
     * @param  \Honed\Action\Action  ...$actions
     */
    public static function make(...$actions)
    {
        return resolve(static::class)
            ->withActions($actions);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'endpoint' => $this->getEndpoint(),
            'actions' => $this->getActions(),
        ];
    }
}
