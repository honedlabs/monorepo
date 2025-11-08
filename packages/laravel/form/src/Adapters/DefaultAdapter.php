<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Components\Component;
use Honed\Form\Components\Input;
use Honed\Form\Contracts\DataAdapter;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @extends Adapter<\Honed\Form\Components\Input>
 */
class DefaultAdapter extends Adapter
{
    /**
     * Get the class string of the component to be generated.
     *
     * @return class-string<\Honed\Form\Components\Input>
     */
    public function field(): string
    {
        return Input::class;
    }

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvertProperty(DataProperty $property): bool
    {
        return true;
    }

    /**
     * Determine if the request rules are a valid candidate for conversion.
     * @param list<string|\Closure|\Illuminate\Validation\Rule> $rules
     */
    public function shouldConvertRules(string $key, array $rules): bool
    {
        return true;
    }
}
