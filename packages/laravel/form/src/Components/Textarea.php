<?php

declare(strict_types=1);

namespace Honed\Form\Components;

class Textarea extends Input
{
    /**
     * The name of the component.
     */
    public function component(): string
    {
        /** @var string */
        return config('form.components.textarea', 'Textarea.vue');
    }
}
