<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Value
{
    public function __construct(
        protected readonly ?string $value = null,
    ) {
    }

    /**
     * Get the value.
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}
