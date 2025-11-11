<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Closure;
use Honed\Form\Components\Component;
use Honed\Form\Components\NumberInput;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @extends Adapter<\Honed\Form\Components\NumberInput>
 */
class NumberAdapter extends Adapter
{
    /**
     * Get the class string of the component to be generated.
     *
     * @return class-string<NumberInput>
     */
    public function field(): string
    {
        return NumberInput::class;
    }

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvertProperty(DataProperty $property, DataClass $dataClass): bool
    {
        return $property->type->type->acceptsType('int')
            || $property->type->type->acceptsType('float');
    }

    /**
     * Determine if the request rules are a valid candidate for conversion.
     *
     * @param  list<string|Closure|\Illuminate\Validation\Rule>  $rules
     */
    public function shouldConvertRules(string $key, array $rules): bool
    {
        return in_array('number', $rules);
    }

    /**
     * Define the attributes which should be assigned to the component from the data property.
     *
     * @return array<string, mixed>
     */
    protected function assignFromProperty(DataProperty $property): array
    {
        return [
            ...parent::assignFromProperty($property),
            'min' => $this->getMinFromProperty($property),
            'max' => $this->getMaxFromProperty($property),
        ];
    }
}
