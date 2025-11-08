<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Attributes\Component as ComponentAttribute;
use Honed\Form\Components\Component;
use Honed\Form\Components\DateField;
use Honed\Form\Contracts\DataAdapter;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @extends Adapter<\Honed\Form\Components\DateField>
 */
class CustomAdapter implements DataAdapter
{
    // use Adaptable;

    public function getComponent(DataProperty $property, DataClass $dataClass): ?Component
    {
        if (! $attribute = $property->attributes->first(ComponentAttribute::class)) {
            return null;
        }

        dd($attribute->getComponent());
        
    }

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvert(DataProperty $property): bool
    {
        return $property->attributes->has(Component::class);
    }
}
