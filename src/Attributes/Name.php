<?php

namespace Honed\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Name
{
    public function __construct(
        protected readonly string $name,
    ) {}

    /**
     * Get the name.
     */
    public function getName(): string
    {
        return $this->name;
    }
}
