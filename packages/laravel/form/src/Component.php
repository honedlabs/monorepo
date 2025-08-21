<?php

declare(strict_types=1);

namespace Honed\Form;

use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;
use Honed\Form\Concerns\HasComponent;

abstract class Component extends Primitive implements NullsAsUndefined
{
    use HasComponent;

    /**
     * Get the array representation of the form component.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'component' => $this->getComponent(),
            'attributes' => null,
        ];
    }
}