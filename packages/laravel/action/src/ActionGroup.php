<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\Concerns\HasActions;
use Honed\Core\Primitive;

class ActionGroup extends Primitive
{
    use HasActions;

    public static function make(array $actions = []): static
    {
        return resolve(static::class);
    }

    public function for()
    {
        // Builder or query
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'actions' => $this->getActions(),
        ];
    }

    public function _call($method, $parameters)
    {
        // if ($method === 'actions') {
        //     return $this->getActions();
        // }

        // return parent::_call($method, $parameters);
    }    
}