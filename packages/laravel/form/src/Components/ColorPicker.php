<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Form\Enums\FormComponent;

class ColorPicker extends Field
{
    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'color';

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Color;
    }
}
