<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Abstracts\Grouping;
use Honed\Form\Contracts\DefaultComponent;

class Fieldset extends Grouping implements DefaultComponent
{
    /**
     * Get the component to use from the config.
     */
    public function getConfigComponent(): string
    {
        /** @var string */
        return config('form.components.fieldset', 'Fieldset.vue');
    }
}