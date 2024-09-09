<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Type
{
    public function __construct(
        protected readonly string $type,
    ) {
    }

    /**
     * Get the type.
     */
    public function getType(): string
    {
        return $this->type;
    }
}
