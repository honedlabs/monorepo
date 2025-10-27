<?php

declare(strict_types=1);

namespace Honed\Data\Attributes;

use Attribute;
use Honed\Data\Contracts\PreparesPropertyValue;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Segment implements PreparesPropertyValue
{
    /**
     * @param  non-empty-string  $delimiter
     */
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

        $value = $properties[$dataProperty->name] ?? null;

        if (! is_scalar($value)) {
            return null;
        }

        return explode($this->delimiter, (string) $value);
    }
}
