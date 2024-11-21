<?php

namespace Honed\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Property
{
    public function __construct(
        protected readonly string $property,
    ) {}

    /**
     * Get the property.
     */
    public function getProperty(): string
    {
        return $this->property;
    }
}
