<?php

namespace Honed\Data\Contracts;

use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @template TData of \Spatie\LaravelData\Contracts\BaseData
 */
interface PreparesPropertyValue
{
    /**
     * Overwrite the property value before it is validated.
     * 
     * @param array<string, mixed> $properties
     * @param CreationContext<TData> $creationContext
     */
    public function overwrite(
        DataProperty $dataProperty,
        mixed $payload,
        array $properties,
        CreationContext $creationContext
    ): mixed;
}
