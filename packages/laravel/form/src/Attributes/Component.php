<?php

declare(strict_types=1);

namespace Honed\Form\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Component
{
    /**
     * The arguments for the component.
     *
     * @var array<string, mixed>
     */
    public $arguments;

    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Form\Components\Component>  $component
     * @param  array<string, mixed>  $arguments
     */
    public function __construct(
        public string $component,
        mixed ...$arguments
    ) {
        // @phpstan-ignore-next-line assign.propertyType
        $this->arguments = $arguments;
    }

    /**
     * Get the component class.
     *
     * @return class-string<\Honed\Form\Components\Component>
     */
    public function getComponent(): string
    {
        return $this->component;
    }

    /**
     * Get the arguments for the component.
     *
     * @return array<string, mixed>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
