<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Contracts\DataAdapter;
use Illuminate\Support\Arr;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Support\DataProperty;

abstract class Adapter implements DataAdapter
{
    /**
     * Get the minimum value for the property.
     */
    public function getMin(DataProperty $property): ?int
    {
        $parameter = $property->attributes
            ->first(Min::class)
            ?->parameters()[0];

        return is_int($parameter) ? $parameter : null;
    }

    /**
     * Get the maximum value for the property.
     */
    public function getMax(DataProperty $property): ?int
    {
        $parameter = $property->attributes
            ->first(Max::class)
            ?->parameters()[0];

        return is_int($parameter) ? $parameter : null;
    }

    /**
     * Get the name of the property.
     */
    public function getName(DataProperty $property): string
    {
        return $property->outputMappedName ?: $property->name;
    }
}