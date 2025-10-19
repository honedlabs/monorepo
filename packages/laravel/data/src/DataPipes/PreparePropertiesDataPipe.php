<?php

declare(strict_types=1);

namespace Honed\Data\DataPipes;

use Honed\Data\Contracts\PreparesPropertyValue;
use Illuminate\Http\Request;
use Spatie\LaravelData\DataPipes\DataPipe;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\Creation\ValidationStrategy;
use Spatie\LaravelData\Support\DataClass;

class PreparePropertiesDataPipe implements DataPipe
{
    /**
     * Handle the data pipe.
     *
     * @param  array<string, mixed>  $properties
     * @param CreationContext<*> $creationContext
     */
    public function handle(
        mixed $payload,
        DataClass $class,
        array $properties,
        CreationContext $creationContext
    ): array {

        if (! $payload instanceof Request
            || $creationContext->validationStrategy === ValidationStrategy::Disabled
            || $creationContext->validationStrategy === ValidationStrategy::AlreadyRan
        ) {
            return $properties;
        }

        foreach ($class->properties as $dataProperty) {
            $attribute = $dataProperty->attributes->first(PreparesPropertyValue::class);

            if ($attribute === null) {
                continue;
            }

            $name = $dataProperty->inputMappedName ?: $dataProperty->name;

            $value = $attribute->overwrite($dataProperty, $payload, $properties, $creationContext);

            $properties[$name] = $value;
        }

        return $properties;
    }
}
