<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Key
{
    public function __construct(
        protected readonly string $key,
    ) {
    }

    /**
     * Get whether the class is key.
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
