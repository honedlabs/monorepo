<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;

interface Formable
{
    public function field(DataProperty $property, mixed $value, TransformationContext $context): mixed;
}