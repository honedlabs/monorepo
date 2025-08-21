<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait CanBeRequired
{
    /**
     * Whether the component should be marked as required.
     * 
     * @var bool
     */
    protected $required = false;

    /**
     * Set the required state of the component.
     * 
     * @return $this
     */
    public function required(bool $value = true): static
    {
        $this->required = $value;

        return $this;
    }

    /**
     * Set the negated required state of the component
     * 
     * @return $this
     */
    public function notRequired(bool $value = true): static
    {
        return $this->required(! $value);
    }

    /**
     * Get the required state of the component.
     */
    public function isRequired(): bool
    {
        return $this->required;
    }
    
    /**
     * Get the negated required state of the component.
     */
    public function isNotRequired(): bool
    {
        return ! $this->isRequired();
    }
}