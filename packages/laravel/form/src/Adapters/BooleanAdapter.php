<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Closure;
use Honed\Form\Components\Checkbox;
use Honed\Form\Components\Component;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @extends Adapter<\Honed\Form\Components\Checkbox>
 */
class BooleanAdapter extends Adapter
{
    /**
     * Get the class string of the component to be generated.
     *
     * @return class-string<Checkbox>
     */
    public function field(): string
    {
        return Checkbox::class;
    }

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvertProperty(DataProperty $property, DataClass $dataClass): bool
    {
        return $property->type->type->acceptsType('bool');
    }

    /**
     * Determine if the request rules are a valid candidate for conversion.
     *
     * @param  list<string|Closure|\Illuminate\Validation\Rule>  $rules
     */
    public function shouldConvertRules(string $key, array $rules): bool
    {
        return in_array('boolean', $rules);
    }
}
