<?php

namespace Honed\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Format
{
    public function __construct(
        protected readonly ?string $format = null,
    ) {}

    /**
     * Get the format.
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }
}
