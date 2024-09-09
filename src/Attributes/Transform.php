<?php

namespace Conquest\Table\Actions\Attributes;

use Closure;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Transform
{
    public function __construct(
        protected readonly Closure $transform,
    ) {
    }

    /**
     * Get the transformer.
     */
    public function getTransform(): Closure
    {
        return $this->transform;
    }
}
