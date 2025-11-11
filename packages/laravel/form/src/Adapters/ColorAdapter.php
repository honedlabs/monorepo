<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Closure;
use Honed\Data\Attributes\Validation\HexColor;
use Honed\Form\Components\ColorPicker;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @extends Adapter<\Honed\Form\Components\ColorPicker>
 */
class ColorAdapter extends Adapter
{
    /**
     * Get the class string of the component to be generated.
     *
     * @return class-string<ColorPicker>
     */
    public function field(): string
    {
        return ColorPicker::class;
    }

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvertProperty(DataProperty $property, DataClass $dataClass): bool
    {
        return $property->attributes->has(HexColor::class);
    }

    /**
     * Determine if the request rules are a valid candidate for conversion.
     *
     * @param  list<string|Closure|\Illuminate\Validation\Rule>  $rules
     */
    public function shouldConvertRules(string $key, array $rules): bool
    {
        return in_array('hex_color', $rules);
    }
}
