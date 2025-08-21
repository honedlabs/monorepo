<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Abstracts\Field;
use Honed\Form\Contracts\DefaultComponent;

class Textarea extends Field implements DefaultComponent
{
    /**
     * Get the component to use from the config.
     */
    public function getConfigComponent(): string
    {
        /** @var string */
        return config('form.components.textarea', 'Textarea.vue');
    }
}