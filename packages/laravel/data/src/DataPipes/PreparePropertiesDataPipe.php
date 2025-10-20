<?php

declare(strict_types=1);

namespace Honed\Data\DataPipes;

use Honed\Data\Contracts\PreparesPropertyValue;
use Illuminate\Http\Request;
use Spatie\LaravelData\DataPipes\DataPipe;
use Spatie\LaravelData\Exceptions\CannotCreateData;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\Creation\ValidationStrategy;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Types\CombinationType;

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

        foreach ($properties as $name => $value) {
            $dataProperty = $class->properties[$name] ?? null;

            if ($dataProperty === null) {
                continue;
            }

            $attribute = $dataProperty->attributes->first(PreparesPropertyValue::class);

            if ($attribute !== null) {
                $properties[$name] = $attribute->overwrite($dataProperty, $payload, $properties, $creationContext);
                continue;
            }

            if (
                $dataProperty->type->kind->isDataObject()
                || $dataProperty->type->kind->isDataCollectable()
            ) {
                try {
                    $context = $creationContext->next($dataProperty->type->dataClass, $name);

                    $data = $dataProperty->type->kind->isDataObject()
                        ? $context->from($value)
                        : $context->collect($value, $dataProperty->type->iterableClass);

                    $creationContext->previous();

                    $properties[$name] = $data;
                } catch (CannotCreateData $exception) {
                    $creationContext->previous();

                    if ($dataProperty->type->type instanceof CombinationType) {
                        return $value;
                    }

                    throw $exception;
                }
            }
        }

        return $properties;
    }
}
