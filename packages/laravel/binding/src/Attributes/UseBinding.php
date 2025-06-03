<?php

namespace Honed\Binding\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class UseBinding
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string  $bindingClass
     * @return void
     */
    public function __construct(public string $bindingClass)
    {
        //
    }
}
