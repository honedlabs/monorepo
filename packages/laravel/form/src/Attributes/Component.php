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
     * @var array<int|string, mixed>
     */
    public $arguments;

    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Form\Components\Component>  $component
     */
    public function __construct(
        public string $component,
        mixed ...$arguments
    ) {
        // if (! is_a($this->component, Component::class, true)) {
        //     C
        // }

        $this->arguments = $arguments;
    }

    // public function get
}
