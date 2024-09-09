<?php

namespace Conquest\Table\Actions\Attributes;

use Closure;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Validate
{
    public function __construct(
        protected readonly Closure $validate,
    ) {
    }

    /**
     * Get the validator.
     */
    public function getValidate(): Closure
    {
        return $this->validate;
    }
}
