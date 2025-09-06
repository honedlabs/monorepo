<?php

declare(strict_types=1);

namespace Honed\Form\Abstracts;

use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Form\Concerns\CanBeAutofocused;
use Honed\Form\Concerns\CanBeDisabled;
use Honed\Form\Concerns\CanBeOptional;
use Honed\Form\Concerns\CanBeRequired;
use Honed\Form\Concerns\HasDefaultValue;
use Honed\Form\Concerns\HasHint;
use Honed\Form\Contracts\Defaultable;

abstract class Field extends Component implements Defaultable
{
    use CanBeAutofocused;
    use CanBeDisabled;
    use CanBeOptional;
    use CanBeRequired;
    use HasHint;
    use HasLabel;
    use HasName;
    use HasDefaultValue;

    /**
     * Create a new field instance.
     */
    public static function make(string $name, ?string $label = null): static
    {
        return resolve(static::class)
            ->name($name)
            ->label($label ?? static::makeLabel($name));
    }

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
            'defaultValue' => $this->getDefaultValue(),
            'required' => $this->isRequired() ?: null,
            'disabled' => $this->isDisabled() ?: null,
            'optional' => $this->isOptional() ?: null,
            'autofocus' => $this->isAutofocused() ?: null,
            ...parent::representation(),
        ];
    }
}
