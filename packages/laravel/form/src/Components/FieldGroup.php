<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Form\Enums\FormComponent;

class FieldGroup extends Grouping
{
    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'fieldGroup';

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::FieldGroup;
    }
}
