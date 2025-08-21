<?php

declare(strict_types=1);

namespace Honed\Form;

use Honed\Core\Concerns\HasDescription;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Form\Concerns\CanBeAutofocused;
use Honed\Form\Concerns\CanBeOptional;
use Honed\Form\Concerns\CanBeRequired;

abstract class FormField extends FormComponent
{
    use CanBeRequired;
    use CanBeOptional;
    use CanBeAutofocused;
    use HasName;
    use HasLabel;
    use HasDescription;
    // use HasAttri;
    // use HasHint;

    /**
     * Get the array representation of the form field.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
            ...parent::representation(),
        ];
    }
}