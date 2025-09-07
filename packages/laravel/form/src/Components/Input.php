<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Abstracts\Field;

class Input extends Field
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
        /** @var string */
        return config('form.components.input', 'Input.vue');
    }

    /**
     * Get the placeholder for when the given value is null.
     */
    public function empty(): mixed
    {
        return '';
    }
}
