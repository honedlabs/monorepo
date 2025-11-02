<?php

declare(strict_types=1);

namespace Honed\Form\Components;

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
    public function component(): string
    {
        return config()->string('honed-form.components.checkbox', 'Checkbox.vue');
    }

    /**
     * Get the placeholder for when the given value is null.
     */
    public function empty(): mixed
    {
        return false;
    }
}
