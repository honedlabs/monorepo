<?php

declare(strict_types=1);

namespace Honed\Form\Components;

class Fieldset extends Grouping
{
    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'fieldset';

    /**
     * The name of the component.
     */
    public function component(): string
    {
        return config()->string('honed-form.components.fieldset', 'Fieldset.vue');
    }
}
