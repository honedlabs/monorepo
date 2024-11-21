<?php

namespace Honed\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Title
{
    public function __construct(
        protected readonly string $title,
    ) {}

    /**
     * Get the title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
