<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use BackedEnum;
use Closure;
use Honed\Form\Components\Component;
use Honed\Form\Components\Select;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @extends Adapter<\Honed\Form\Components\Select>
 */
class EnumAdapter extends Adapter
{
    /**
     * Get the class string of the component to be generated.
     *
     * @return class-string<Select>
     */
    public function field(): string
    {
        return Select::class;
    }

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvertProperty(DataProperty $property, DataClass $dataClass): bool
    {
        return (bool) $property->type->type->findAcceptedTypeForBaseType(BackedEnum::class);
    }

    /**
     * Determine if the request rules are a valid candidate for conversion.
     *
     * @param  list<string|Closure|\Illuminate\Validation\Rule>  $rules
     */
    public function shouldConvertRules(string $key, array $rules): bool
    {
        return in_array('enum', $rules);
    }

    /**
     * Create a new component instance from the data property.
     *
     * @return Select
     */
    public function convertProperty(DataProperty $property, DataClass $dataClass): Component
    {
        /** @var \Spatie\LaravelData\Support\Types\NamedType $type */
        $type = $property->type->type;

        /** @var class-string<BackedEnum> $enum */
        $enum = $type->name;

        return parent::convertProperty($property, $dataClass)
            ->options($enum);
    }
}
