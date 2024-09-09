<?php

namespace Conquest\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Label
{
    public function __construct(
        protected readonly string $label,
    ) {}

    /**
     * Get the label.
     */
    public function getLabel(): string
    {
        return $this->label;
    }
}
