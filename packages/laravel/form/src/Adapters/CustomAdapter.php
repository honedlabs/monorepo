<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Closure;
use Honed\Form\Attributes\Component as ComponentAttribute;
use Honed\Form\Components\Component;
use Honed\Form\Concerns\Adaptable;
use Honed\Form\Contracts\Adapter;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

class CustomAdapter implements Adapter
{
    use Adaptable;

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
            'name' => $this->getName($property),
            'label' => $this->getLabel($property),
            ...$attribute->getArguments(),
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
}
