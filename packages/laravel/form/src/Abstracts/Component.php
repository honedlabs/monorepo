<?php

declare(strict_types=1);

namespace Honed\Form\Abstracts;

use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;
use Honed\Form\Concerns\HasComponent;

abstract class Component extends Primitive implements NullsAsUndefined
{
    /**
     * The name of the component file.
     * 
     * @var string|null
     */
    protected $component;

    abstract public function component(): string;

    /**
     * Get the name of the component file.
     */
    public function getComponent(): string
    {
        return $this->component ??= $this->getDefaultComponent();
    }

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