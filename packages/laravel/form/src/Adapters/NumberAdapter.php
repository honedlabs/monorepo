<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Components\Component;
use Honed\Form\Components\Input;
use Honed\Form\Components\NumberInput;
use Honed\Form\Contracts\DataAdapter;
use Spatie\LaravelData\Attributes\Validation\StringValidationAttribute;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

class NumberAdapter extends Adapter
{
    /**
     * Get the class string of the component to be generated.
     */
    public function field(): string
    {
        return NumberInput::class;
    }

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvertProperty(DataProperty $property): bool
    {
        return $property->type->type->acceptsType('int')
            || $property->type->type->acceptsType('float');
    }


    /**
     * Determine if the request rules are a valid candidate for conversion.
     * @param list<string|\Closure|\Illuminate\Validation\Rule> $rules
     */
    public function shouldConvertRules(string $key, array $rules): bool
    {
        return in_array('number', $rules);
    }
}
