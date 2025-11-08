<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use BackedEnum;
use Honed\Form\Components\Component;
use Honed\Form\Components\Select;
use Honed\Form\Contracts\DataAdapter;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;
use UnitEnum;

class EnumAdapter extends Adapter
{
    /**
     * Get the class string of the component to be generated.
     *
     * @return class-string<\Honed\Form\Components\Select>
     */
    public function field(): string
    {
        return Select::class;
    }

    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvertProperty(DataProperty $property): bool
    {
        return (bool) $property->type->type->findAcceptedTypeForBaseType(BackedEnum::class)
            || (bool) $property->type->type->findAcceptedTypeForBaseType(UnitEnum::class);
    }

    /**
     * Determine if the request rules are a valid candidate for conversion.
     * @param list<string|\Closure|\Illuminate\Validation\Rule> $rules
     */
    public function shouldConvertRules(string $key, array $rules): bool
    {
        return in_array('enum', $rules);
    }
}
