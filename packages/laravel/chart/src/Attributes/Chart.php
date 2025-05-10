<?php

declare(strict_types=1);

namespace Honed\Chart\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Chart
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Chart\Chart>  $chart
     * @return void
     */
    public function __construct(
        public string $chart
    ) {}
}
