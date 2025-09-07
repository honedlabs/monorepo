<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Abstracts\Field;

class Select extends Field
{
    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'select';

    /**
     * The name of the component.
     */
    public function component(): string
    {
        /** @var string */
        return config('form.components.select', 'Select.vue');
    }
}
