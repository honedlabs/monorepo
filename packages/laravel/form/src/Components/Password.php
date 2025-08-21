<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Abstracts\Field;
use Honed\Form\Contracts\DefaultComponent;

class Password extends Field
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