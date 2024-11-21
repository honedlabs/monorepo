<?php

namespace Honed\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Id
{
    public function __construct(
        protected readonly string $id,
    ) {}

    /**
     * Get the id.
     */
    public function getId(): string
    {
        return $this->id;
    }
}
