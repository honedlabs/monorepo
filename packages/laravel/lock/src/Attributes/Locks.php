<?php

declare(strict_types=1);

namespace Honed\Lock\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Locks
{
    /**
     * Create a new attribute instance.
     */
    public function __construct()
    {
        //
    }
}
