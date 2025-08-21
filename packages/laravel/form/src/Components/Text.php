<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Abstracts\Component;
use Honed\Form\Contracts\DefaultComponent;

class Text extends Component implements DefaultComponent
{
    /**
     * Get the component to use from the config.
     */
    public function getConfigComponent(): string
    {
        /** @var string */
        return config('form.components.text', 'Text.vue');
    }
}