<?php

namespace Honed\Crumb\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Crumb
{
    public function __construct(
        protected readonly string $crumb,
    ) { }

    public function getCrumb(): ?string
    {
        return $this->crumb;
    }
}