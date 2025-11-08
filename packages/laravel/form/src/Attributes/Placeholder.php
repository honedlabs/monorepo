<?php

declare(strict_types=1);

namespace Honed\Form\Attributes;

use Attribute;
use Honed\Form\Support\Trans;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Placeholder
{
    /**
     * Create a new attribute instance.
     */
    public function __construct(
        public string|Trans $placeholder
    ) {}

    /**
     * Get the placeholder.
     */
    public function getPlaceholder(): string
    {
        return is_string($this->placeholder) ? $this->placeholder : $this->placeholder->getValue();
    }
}
