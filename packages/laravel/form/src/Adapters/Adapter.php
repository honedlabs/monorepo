<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Attributes\Label;
use Honed\Form\Components\Component;
use Honed\Form\Contracts\DataAdapter;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @template T of \Honed\Form\Components\Field
 */
abstract class Adapter implements DataAdapter
{
    /**
     * Get the class string of the component to be generated.
     * 
     * @return class-string<T>
     */
    abstract public function field(): string;

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    abstract public function shouldConvert(DataProperty $property): bool;

    /**
     * Get the form component for the data property.
     * 
     * @return ?T
     */
    public function getComponent(DataProperty $property, DataClass $dataClass): ?Component
    {
        if ($this->shouldConvert($property)) {
            return $this->convert($property);
        }

        return null;
    }

    /**
     * Create a new component instance.
     * 
     * @return T
     */
    public function convert(DataProperty $property): Component
    {
        $name = $this->getName($property);
        $label = $this->getLabel($property);

        return $this->field($property)::make($name, $label);
    }

    /**
     * Get the label for the property.
     */
    public function getLabel(DataProperty $property): ?string
    {
        return $property->attributes
            ->first(Label::class)
            ?->getLabel();
    }

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
