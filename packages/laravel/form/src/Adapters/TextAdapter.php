<?php

declare(strict_types=1);

namespace Honed\Form\Adapters;

use Closure;
use Honed\Form\Components\Component;
use Honed\Form\Components\Input;
use Honed\Form\Components\Textarea;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @extends DefaultAdapter<\Honed\Form\Components\Input|\Honed\Form\Components\Textarea>
 */
class TextAdapter extends DefaultAdapter
{
    /**
     * Determine if the property is a valid candidate for conversion.
     */
    public function shouldConvertProperty(DataProperty $property, DataClass $dataClass): bool
    {
        return $property->type->type->acceptsType('string');
    }

    /**
     * Determine if the request rules are a valid candidate for conversion.
     *
     * @param  list<string|Closure|\Illuminate\Validation\Rule>  $rules
     */
    public function shouldConvertRules(string $key, array $rules): bool
    {
        return in_array('string', $rules);
    }

    /**
     * Create a new component instance from the data property.
     *
     * @return Input|Textarea
     */
    public function convertProperty(DataProperty $property, DataClass $dataClass): Component
    {
        if (((int) $this->getMaxFromProperty($property)) > 255) {
            return Textarea::make($this->getNameFromProperty($property), $this->getLabelFromProperty($property));
        }

        return parent::convertProperty($property, $dataClass);
    }
}
