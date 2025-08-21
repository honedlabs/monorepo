<?php

declare(strict_types=1);

namespace Honed\Form\Abstracts;

use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Form\Concerns\CanBeAutofocused;
use Honed\Form\Concerns\CanBeOptional;
use Honed\Form\Concerns\CanBeRequired;
use Honed\Form\Concerns\HasHint;

abstract class Field extends Component
{
    use CanBeRequired;
    use CanBeOptional;
    use CanBeAutofocused;
    use HasName;
    use HasLabel;
    // use HasAttri;
    use HasHint;

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
            'hint' => $this->getHint(),
            'required' => $this->isRequired() ?: null,
            'disabled' => $this->isDisabled() ?: null,
            'optional' => $this->isOptional() ?: null,
            'autofocus' => $this->isAutofocused() ?: null,
            ...parent::representation(),
        ];
    }
}