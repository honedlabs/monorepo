<?php

declare(strict_types=1);

namespace Honed\List\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class List
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\List\List>  $list
     * @return void
     */
    public function __construct(
        public string $list
    ) {}
}
