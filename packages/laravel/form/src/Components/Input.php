<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Form\Enums\FormComponent;

class Input extends Field
{
    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'input';

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Input;
    }

    /**
     * Set the type of the input to text.
     * 
     * @return $this
     */
    public function text(): static
    {
        return $this->attribute('type', 'text');
    }

    /**
     * Set the type of the input to password.
     * 
     * @return $this
     */
    public function password(): static
    {
        return $this->attribute('type', 'password');
    }

    /**
     * Set the type of the input to file.
     * 
     * @return $this
     */
    public function file(): static
    {
        return $this->attribute('type', 'file');
    }
}
