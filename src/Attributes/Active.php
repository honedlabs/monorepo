<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Active
{
    public function __construct(
        protected readonly bool $active = true,
    ) {
    }

    /**
     * Get whether the class is active.
     */
    public function getActive(): bool
    {
        return $this->active;
    }
}
