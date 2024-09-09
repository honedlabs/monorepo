<?php

namespace Conquest\Table\Actions\Attributes;

use Attribute;
use Closure;

#[Attribute(Attribute::TARGET_CLASS)]
class Authorize
{
    public function __construct(
        protected readonly bool|Closure $authorize,
    ) {
    }

    /**
     * Get whether the class is authorize.
     */
    public function getAuthorize(): bool|Closure
    {
        return $this->authorize;
    }
}
