<?php

declare(strict_types=1);

namespace Honed\Form;

use Honed\Form\Concerns\HasSchema;
use Honed\Form\Contracts\DefaultComponent;

class FieldGroup extends Component implements DefaultComponent
{
    use HasSchema;

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
        return config('form.components.fieldgroup', 'FieldGroup.vue');
    }

    /**
     * Get the array representation of the fieldgroup.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'schema' => $this->getSchema(),
            ...parent::representation(),
        ];
    }
}