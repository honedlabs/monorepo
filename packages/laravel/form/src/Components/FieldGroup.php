<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Abstracts\Grouping;

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
        /** @var string */
        return config('form.components.fieldgroup', 'FieldGroup.vue');
    }
}
