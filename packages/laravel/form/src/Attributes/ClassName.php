<?php

declare(strict_types=1);

namespace Honed\Form\Attributes;

use Attribute;
use Honed\Form\Support\FunctionalArgument;

/**
 * @extends FunctionalArgument<string>
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class ClassName extends FunctionalArgument
{
    public function __construct(
        public string $className
    ) {}

    /**
     * Get the class.
     */
    public function getValue(): string
    {
        return $this->className;
    }
}
