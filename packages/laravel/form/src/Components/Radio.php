<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Form\Enums\FormComponent;
use Honed\Option\Concerns\HasOptions;

class Radio extends Field
{
    use HasOptions;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'radio';

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Radio;
    }

    /**
     * Get the array representation of the radio.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'options' => $this->getOptionsArray(),
        ];
    }
}
