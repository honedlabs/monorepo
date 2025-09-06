<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Abstracts\Field;

class Checkbox extends Field
{
    /**
     * The name of the component.
     */
    public function component(): string
    {
        /** @var string */
        return config('form.components.checkbox', 'Checkbox.vue');
    }

    /**
     * Get the placeholder for when the given value is null.
     */
    public function empty(): mixed
    {
        return false;
    }
}
