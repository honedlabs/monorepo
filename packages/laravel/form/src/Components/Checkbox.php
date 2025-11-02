<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Form\Enums\FormComponent;

class Checkbox extends Field
{
    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'checkbox';

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Checkbox;
    }

    /**
     * Get the placeholder for when the given value is null.
     */
    public function empty(): mixed
    {
        return false;
    }
}
