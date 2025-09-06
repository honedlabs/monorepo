<?php

declare(strict_types=1);

namespace Honed\Form\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class UseForm
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Form\Form>  $formClass
     */
    public function __construct(
        public string $formClass
    ) {}
}