<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Attributes\Hint;
use Honed\Form\Attributes\Label;
use Honed\Form\Attributes\Placeholder;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Support\DataProperty;

trait Adaptable
{
    /**
     * Get the name of the property.
     */
    public function getName(DataProperty $property): string
    {
        return $property->outputMappedName ?: $property->name;
    }

    /**
     * Get the label for the property.
     */
    public function getLabel(DataProperty $property): ?string
    {
        return $property->attributes->first(Label::class)?->getLabel();
    }

    /**
     * Get the minimum value for the property.
     */
    public function getPropertyMin(DataProperty $property): ?int
    {
        $parameter = $property->attributes->first(Min::class)?->parameters()[0];

        return is_int($parameter) ? $parameter : null;
    }

    /**
     * Get the maximum value for the property.
     */
    public function getPropertyMax(DataProperty $property): ?int
    {
        $parameter = $property->attributes->first(Max::class)?->parameters()[0];

        return is_int($parameter) ? $parameter : null;
    }

    /**
     * Get the hint for the property.\
     */
    public function getHint(DataProperty $property): ?string
    {
        return $property->attributes->first(Hint::class)?->getHint();
    }

    /**
     * Get the placeholder for the property.
     */
    public function getPlaceholder(DataProperty $property): ?string
    {
        return $property->attributes->first(Placeholder::class)?->getPlaceholder();
    }

    // public function isRequired(DataProperty $property): bool
    // {
    //     return $property->attributes->first(Required::class)?->isRequired();
    // }
}
