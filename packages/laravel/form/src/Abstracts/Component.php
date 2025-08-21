<?php

declare(strict_types=1);

namespace Honed\Form\Abstracts;

use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;
use Honed\Form\Concerns\HasComponent;

abstract class Component extends Primitive implements NullsAsUndefined
{
    /**
     * The name of the component.
     * 
     * @var string|null
     */
    protected $component;

    /**
     * The name of the component.
     */
    abstract public function component(): string;

    /**
     * Set the name of the component.
     * 
     * @return $this
     */
    public function asComponent(string $value): static
    {
        $this->component = $value;

        return $this;
    }

    /**
     * Get the name of the component.
     */
    public function getComponent(): string
    {
        return $this->component ??= $this->component();
    }

    /**
     * Get the array representation of the component.
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