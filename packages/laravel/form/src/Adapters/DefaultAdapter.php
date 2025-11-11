<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Closure;
use Honed\Form\Components\Component;
use Honed\Form\Components\Input;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @template T of \Honed\Form\Components\Field = \Honed\Form\Components\Input
 * 
 * @extends Adapter<T>
 */
class DefaultAdapter extends Adapter
{
    /**
     * Get the class string of the component to be generated.
     *
     * @return class-string<Input>
     */
    public function field(): string
    {
        return Input::class;
    }

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvertProperty(DataProperty $property, DataClass $dataClass): bool
    {
        return true;
    }

    /**
     * Determine if the request rules are a valid candidate for conversion.
     *
     * @param  list<string|Closure|\Illuminate\Validation\Rule>  $rules
     */
    public function shouldConvertRules(string $key, array $rules): bool
    {
        return true;
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
            'placeholder' => $this->getPlaceholderFromProperty($property),
        ];
    }
}
