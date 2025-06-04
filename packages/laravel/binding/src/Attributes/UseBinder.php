<?php

declare(strict_types=1);

namespace Honed\Binding\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class UseBinder
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Binding\Binder>  $bindingClass
     * @return void
     */
    public function __construct(
        public string $bindingClass)
    { }
}
