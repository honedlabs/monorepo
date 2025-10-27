<?php

declare(strict_types=1);

namespace Honed\Data\Attributes;

use Attribute;
use Honed\Data\Contracts\PreparesPropertyValue;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

#[Attribute(Attribute::TARGET_PROPERTY)]
class OnlyFilename implements PreparesPropertyValue
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
    ): mixed {

        $value = $properties[$dataProperty->name] ?? null;

        if (! is_scalar($value)) {
            return $value;
        }

        return pathinfo((string) $value, PATHINFO_BASENAME) ?: null;
    }
}
