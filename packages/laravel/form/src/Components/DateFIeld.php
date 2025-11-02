<?php

declare(strict_types=1);

namespace Honed\Form\Components;

class DateField extends Field
{
    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'dateField';

    /**
     * The name of the component.
     */
    public function component(): string
    {
        return config()->string('honed-form.components.date-field', 'DateField.vue');
    }
}
