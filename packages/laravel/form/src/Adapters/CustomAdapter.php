<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Closure;
use Honed\Form\Attributes\Components\Component as ComponentAttribute;
use Honed\Form\Components\Component;
use Honed\Form\Contracts\Adapter;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

class CustomAdapter extends FromPropertyAdapter implements Adapter
{
    /**
     * Get the form component for the data property.
     */
    public function getPropertyComponent(DataProperty $property, DataClass $dataClass): ?Component
    {
        if (! $attribute = $property->attributes->first(ComponentAttribute::class)) {
            return null;
        }

        $component = app($attribute->getComponent());

        return $component->assign([
            ...$attribute->getArguments(),
            ...$this->rejectNulls($this->assignFromProperty($property)),
        ]);
    }

    /**
     * Get the form component for the request rules.
     *
     * @param  list<string|Closure|\Illuminate\Validation\Rule>  $rules
     */
    public function getRulesComponent(string $key, array $rules): ?Component
    {
        return null;
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
            'multiple' => $this->isMultipleProperty($property),
            'name' => $this->getNameFromProperty($property),
            'label' => $this->getLabelFromProperty($property),
            'min' => $this->getMinFromProperty($property),
            'max' => $this->getMaxFromProperty($property),
            'placeholder' => $this->getPlaceholderFromProperty($property),
        ];
    }
}
