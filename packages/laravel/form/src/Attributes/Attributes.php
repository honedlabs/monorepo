<?php

declare(strict_types=1);

namespace Honed\Form\Attributes;

use Attribute;
use Honed\Form\Support\FunctionalArgument;

/**
 * @extends FunctionalArgument<array<string, mixed>>
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Attributes extends FunctionalArgument
{
    /**
     * Create a new attribute instance.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public array $attributes = []
    ) {}

    /**
     * Get the attributes.
     *
     * @return array<string, mixed>
     */
    public function getValue(): array
    {
        return $this->attributes;
    }
}
