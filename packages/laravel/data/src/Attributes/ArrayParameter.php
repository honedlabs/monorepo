<?php

declare(strict_types=1);

namespace Honed\Data\Attributes;

use Attribute;
use Honed\Data\Contracts\PreparesPropertyValue;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayParameter implements PreparesPropertyValue
{
    public function __construct(
        public string $key
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

        return match (true) {
            ! is_array($value) => $value,
            $dataProperty->type->isMixed => ($value[$this->key] ?? null),
            $dataProperty->type->acceptsType('array') => array_column($value, $this->key),
            default => ($value[$this->key] ?? null),
        };
    }
}
