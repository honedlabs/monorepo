<?php

declare(strict_types=1);

namespace Honed\Data\Attributes;

use Attribute;
use Honed\Data\Contracts\PreparesPropertyValue;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Delimit implements PreparesPropertyValue
{
    public function __construct(
        protected string $delimiter = ','
    ) {}

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

        $name = $dataProperty->inputMappedName ?: $dataProperty->name;
        $value = $properties[$name] ?? null;

        if (! is_array($value)) {
            return $value;
        }

        return implode($this->delimiter, array_map(
            fn (mixed $value) => is_scalar($value) ? (string) $value : '',
            $value
        ));
    }
}
