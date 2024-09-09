<?php

namespace Conquest\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Value
{
    public function __construct(
        protected readonly mixed $value,
    ) {
    }

    /**
     * Get the value.
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
