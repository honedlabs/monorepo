<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class AsKey
{
    public function __construct(
        protected readonly bool $asKey = true,
    ) {
    }

    /**
     * Get the key.
     */
    public function getKey(): bool
    {
        return $this->asKey;
    }
}
