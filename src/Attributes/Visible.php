<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Visible
{
    public function __construct(
        protected readonly bool $visible = true,
    ) {}

    /**
     * Get the visible.
     */
    public function getVisible(): bool
    {
        return $this->visible;
    }
}
