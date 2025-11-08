<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Honed\Form\Components\Component;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;
use Honed\Form\Contracts\Adapter as AdapterContract;
use Honed\Form\Concerns\Adaptable;

/**
 * @template T of \Honed\Form\Components\Field
 */
abstract class Adapter implements AdapterContract
{
    use Adaptable;

    /**
     * Get the class string of the component to be generated.
     * 
     * @return class-string<T>
     */
    abstract public function field(): string;

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    abstract public function shouldConvertProperty(DataProperty $property): bool;

    /**
     * Determine if the request rules are a valid candidate for conversion.
     * 
     * @param list<string|\Closure|\Illuminate\Validation\Rule> $rules
     */
    abstract public function shouldConvertRules(string $key, array $rules): bool;

    /**
     * Get the form component for the data property.
     * 
     * @return ?T
     */
    public function getPropertyComponent(DataProperty $property, DataClass $dataClass): ?Component
    {
        if ($this->shouldConvertProperty($property, $dataClass)) {
            return $this->convertProperty($property, $dataClass);
        }

        return null;
    }

    /**
     * Get the form component for the request rules.
     * 
     * @param list<string|\Closure|\Illuminate\Validation\Rule> $rules
     * @return ?T
     */
    public function getRulesComponent(string $key, array $rules): ?Component
    {
        if ($this->shouldConvertRules($key, $rules)) {
            return $this->convertRules($key, $rules);
        }

        return null;
    }

    /**
     * Create a new component instance from the data property.
     * 
     * @return T
     */
    public function convertProperty(DataProperty $property, DataClass $dataClass): Component
    {
        $name = $this->getName($property);
        $label = $this->getLabel($property);

        return $this->newComponent($name, $label);
    }

    /**
     * Create a new component instance from the request rules.
     * 
     * @param list<string|\Closure|\Illuminate\Validation\Rule> $rules
     * @return T
     */
    public function convertRules(string $key, array $rules): Component
    {
        return $this->newComponent($key);
    }

    /**
     * Create a new component instance.
     * 
     * @return T
     */
    public function newComponent(string $name, ?string $label = null): Component
    {
        return $this->field($name)::make($name, $label);
    }
}
