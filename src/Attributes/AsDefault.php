<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class AsDefault
{
    public function __construct(
        protected readonly bool $default = true,
    ) {
    }

    /**
     * Get whether the class is default.
     */
    public function getDefault(): bool
    {
        return $this->default;
    }
}
