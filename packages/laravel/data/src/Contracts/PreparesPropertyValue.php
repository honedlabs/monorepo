<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

interface PreparesPropertyValue
{
    /**
     * Overwrite the property value before it is validated.
     *
     * @param  array<string, mixed>  $properties
     * @param CreationContext<*> $creationContext
     */
    public function overwrite(
        DataProperty $dataProperty,
        mixed $payload,
        array $properties,
        CreationContext $creationContext
    ): mixed;
}
