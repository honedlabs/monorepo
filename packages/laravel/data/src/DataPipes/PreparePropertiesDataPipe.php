<?php

declare(strict_types=1);

namespace Honed\Data\DataPipes;

use Honed\Data\Contracts\PreparesPropertyValue;
use Illuminate\Http\Request;
use Spatie\LaravelData\DataPipes\DataPipe;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\Creation\ValidationStrategy;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataConfig;

class PreparePropertiesDataPipe implements DataPipe
{
    /**
     * Create a new prepare properties data pipe.
     */
    public function __construct(
        protected DataConfig $config
    ) {}

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
                $value = $attribute->overwrite($dataProperty, $payload, $properties, $creationContext);

                $properties[$name] = $value;

                continue;
            }

            if (
                (
                    $dataProperty->type->kind->isDataObject()
                    || $dataProperty->type->kind->isDataCollectable()
                ) && $dataProperty->type->dataClass !== null
            ) {
                $dataClass = $this->config->getDataClass($dataProperty->type->dataClass);

                // @phpstan-ignore-next-line
                $value = $this->handle($payload, $dataClass, (array) $value, $creationContext);

                $properties[$name] = $value;
            }
        }

        return $properties;
    }
}
