<?php

declare(strict_types=1);

namespace Honed\Form\Attributes;

use Attribute;
use Honed\Form\Support\Trans;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Hint
{
    /**
     * Create a new attribute instance.
     */
    public function __construct(
        public string|Trans $hint
    ) {}

    /**
     * Get the hint.
     */
    public function getHint(): string
    {
        return is_string($this->hint) ? $this->hint : $this->hint->getValue();
    }
}
