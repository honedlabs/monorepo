<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Transformers;

use Attribute;
use Spatie\LaravelData\Attributes\WithTransformer;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class TransformToData extends WithTransformer
{
    public function __construct(

    ) {}
}