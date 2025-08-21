<?php

declare(strict_types=1);

namespace Honed\Form;

use Honed\Form\Contracts\DefaultComponent;

class Fieldset extends FormComponent implements DefaultComponent
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->component($this->getConfigComponent());
    }

    /**
     * Get the component to use from the config.
     */
    public function getConfigComponent(): string
    {
        /** @var string */
        return config('form.components.fieldset', 'Fieldset.vue');
    }
}