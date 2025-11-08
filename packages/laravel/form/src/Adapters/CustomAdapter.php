<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Attributes\Component as ComponentAttribute;
use Honed\Form\Components\Component;
use Honed\Form\Components\DateField;
use Honed\Form\Concerns\Adaptable;
use Honed\Form\Contracts\Adapter;
use Honed\Form\Contracts\DataAdapter;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

class CustomAdapter extends Adapter
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

        return null;
    }

    /**
     * Get the form component for the request rules.
     * 
     * @param list<string|\Closure|\Illuminate\Validation\Rule> $rules
     */
    public function getRulesComponent(string $key, array $rules): ?Component
    {
        return null;
    }
}
