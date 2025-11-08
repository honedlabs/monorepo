<?php

declare(strict_types=1);

namespace Honed\Form\Attributes;

use Attribute;
use Honed\Form\Support\Trans;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Label
{
    /**
     * Create a new attribute instance.
     */
    public function __construct(
        public string|Trans $label
    ) {}

    /**
     * Get the label.
     */
    public function getLabel(): string
    {
        return is_string($this->label) ? $this->label : $this->label->getValue();
    }
}
