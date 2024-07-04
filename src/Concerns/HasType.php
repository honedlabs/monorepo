<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set a type property on a class
 */
trait HasType
{
    protected string|Closure|null $type = null;

    /**
     * Set the type property, chainable
     * 
     * @param string|Closure $type
     * @return static
     */
    public function type(string|Closure $type): static
    {
        $this->setType($type);
        return $this;
    }

    /**
     * Set the type property quietly.
     * 
     * @param string|Closure $type
     * @return void
     */
    public function setType(string|Closure|null $type): void
    {
        if (is_null($type)) return;
        $this->type = $type;
    }

    /**
     * Get the class type
     * 
     * @return string
     */
    public function getType(): ?string
    {
        return $this->evaluate($this->type);
    }

    /**
     * Check if the class has a type
     * 
     * @return bool
     */
    public function hasType(): bool
    {
        return !is_null($this->type);
    }
}
