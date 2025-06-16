<?php

declare(strict_types=1);

namespace Honed\List\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class UseInfolist
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\List\Infolist>  $listClass
     * @return void
     */
    public function __construct(
        public string $listClass
    ) {}
}
