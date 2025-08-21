<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Abstracts\Grouping;
use Honed\Form\Contracts\DefaultComponent;

class Fieldset extends Grouping
{
    /**
     * The name of the component.
     */
    public function component(): string
    {
        /** @var string */
        return config('form.components.fieldset', 'Fieldset.vue');
    }
}