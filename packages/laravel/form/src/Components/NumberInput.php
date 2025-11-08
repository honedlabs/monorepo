<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Form\Enums\FormComponent;

class NumberInput extends Input
{
    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'input';

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Number;
    }

    /**
     * Get the placeholder for when the given value is null.
     * 
     * @return int
     */
    public function empty(): mixed
    {
        return 0;
    }
}
