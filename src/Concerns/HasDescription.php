<?php

namespace Conquest\Core\Concerns;

use Closure;

trait HasDescription
{
    protected string|Closure|null $description = null;

    /**
     * Set the description, chainable.
     * 
     * @param string|Closure $description
     * @return static
     */
    public function description(string|Closure $description): static
    {
        $this->setDescription($description);
        return $this;
    }

    /**
     * Set the description quietly.
     * 
     * @param string|Closure $description
     * @return void
     */
    public function setDescription(string|Closure|null $description): void
    {
        if (is_null($description)) return;
        $this->description = $description;
    }

    /**
     * Get the description
     * 
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->evaluate($this->description);
    }

    /**
     * Determine if the class has a description.
     * 
     * @return bool
     */
    public function hasDescription(): bool
    {
        return !is_null($this->description);
    }

    /**
     * Determine if the class does not have a description.
     * 
     * @return bool
     */
    public function lacksDescription(): bool
    {
        return !$this->hasDescription();
    }
}
