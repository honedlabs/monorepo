<?php

declare(strict_types=1);

namespace Honed\Form\Components;

class Password extends Input
{
    /**
     * The name of the component.
     */
    public function component(): string
    {
        /** @var string */
        return config('form.components.password', 'Password.vue');
    }
}
