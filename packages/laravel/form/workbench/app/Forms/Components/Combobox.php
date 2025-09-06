<?php

namespace App\Forms\Components;

use Honed\Form\Abstracts\Field;

class Combobox extends Field
{
    /**
     * The name of the component.
     */
    public function component(): string
    {
        return 'Combobox.vue';
    }
}
