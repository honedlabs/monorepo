<?php

declare(strict_types=1);

namespace Honed\Form\Components;

class Input extends TextField
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
    public function component(): string
    {
        return config()->string('honed-form.components.input', 'Input.vue');
    }
}
