<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Concerns\Adaptable;
use Honed\Form\Contracts\DataAdapter;
use Spatie\LaravelData\Support\DataProperty;

abstract class FromPropertyAdapter implements DataAdapter
{
    use Adaptable;

    /**
     * Reject null values from the array.
     *
     * @param  array<array-key, mixed>  $value
     * @return array<array-key, mixed>
     */
    protected function rejectNulls(array $value): array
    {
        return array_filter(
            $value,
            static fn ($value) => $value !== null
        );
    }

    /**
     * Define the attributes which should be assigned to the component from the data property.
     *
     * @return array<string, mixed>
     */
    protected function assignFromProperty(DataProperty $property): array
    {
        return [
            'required' => $this->isRequiredProperty($property),
            'optional' => $this->isOptionalProperty($property),
            'hint' => $this->getHintFromProperty($property),
            'attributes' => $this->getAttributesFromProperty($property),
            'defaultValue' => $this->getDefaultValueFromProperty($property),
        ];
    }
}
