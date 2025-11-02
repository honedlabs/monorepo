<?php

declare(strict_types=1);

namespace Honed\Form\Components;

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
    public function component(): string
    {
        return config()->string('honed-form.components.fieldgroup', 'FieldGroup.vue');
    }
}
