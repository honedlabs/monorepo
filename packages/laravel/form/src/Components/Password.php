<?php

declare(strict_types=1);

namespace Honed\Form\Components;

class Password extends Input
{
    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'password';

    /**
     * The name of the component.
     */
    public function component(): string
    {
        return config()->string('honed-form.components.password', 'Password.vue');
    }
}
