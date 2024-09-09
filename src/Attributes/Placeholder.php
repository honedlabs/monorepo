<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Placeholder
{
    public function __construct(
        protected readonly ?string $placeholder = null,
    ) {
    }

    /**
     * Get the placeholder.
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }
}
