<?php

declare(strict_types=1);

namespace Honed\Widget\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Widgets
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Widget\Widget>|array<int, class-string<\Honed\Widget\Widget>>  $widgets
     * @return void
     */
    public function __construct(
        public string|array $widgets
    ) {}
}