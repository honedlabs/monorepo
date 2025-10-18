<?php

declare(strict_types=1);

namespace Honed\Data\Attributes;

use Honed\Data\Contracts\PreparesPropertyValue;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Creation\CreationContext;

class ArrayParameter implements PreparesPropertyValue
{
    public function __construct(
        public string $key
    ) {}

    public function overwrite(DataProperty $dataProperty, mixed $payload, array $properties, CreationContext $creationContext): mixed
    {
        return '';
    }

}