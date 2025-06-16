<?php

declare(strict_types=1);

namespace Honed\Infolist\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class UseInfolist
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Infolist\Infolist>  $infolistClass
     * @return void
     */
    public function __construct(
        public string $infolistClass
    ) {}
}
