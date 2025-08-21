<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait CanBeOptional
{
    /**
     * Whether the component should be marked as optional.
     * 
     * @var bool
     */
    protected $optional = false;

    /**
     * Set the optional state of the component.
     * 
     * @return $this
     */
    public function optional(bool $value = true): static
    {
        $this->optional = $value;

        return $this;
    }

    /**
     * Set the negated optional state of the component
     * 
     * @return $this
     */
    public function notOptional(bool $value = true): static
    {
        return $this->optional(! $value);
    }

    /**
     * Get the optional state of the component.
     */
    public function isOptional(): bool
    {
        return $this->optional;
    }
    
    /**
     * Get the negated optional state of the component.
     */
    public function isNotOptional(): bool
    {
        return ! $this->isOptional();
    }
}