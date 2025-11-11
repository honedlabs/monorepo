<?php

declare(strict_types=1);

namespace Honed\Form\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Attributes
{
    /**
     * Create a new attribute instance.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public array $attributes = []
    ) {}

    /**
     * Get the attributes.
     *
     * @return array<string, mixed>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
