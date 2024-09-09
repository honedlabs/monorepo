<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Hidden
{
    public function __construct(
        protected readonly bool $hidden = true,
    ) {
    }

    /**
     * Get the hidden.
     */
    public function getHidden(): bool
    {
        return $this->hidden;
    }
}
