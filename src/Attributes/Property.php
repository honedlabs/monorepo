<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Property
{
    public function __construct(
        protected readonly ?string $property = null,
    ) {}

    /**
     * Get the property.
     */
    public function getProperty(): ?string
    {
        return $this->property;
    }
}
