<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Components\DateField;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @extends Adapter<\Honed\Form\Components\DateField>
 */
class DateAdapter extends Adapter
{
    /**
     * Get the class string of the component to be generated.
     *
     * @return class-string<\Honed\Form\Components\DateField>
     */
    public function field(): string
    {
        return DateField::class;
    }

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvert(DataProperty $property): bool
    {
        return $property->attributes->has(Date::class);
    }
}
