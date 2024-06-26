<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set a property on a class
 */
trait HasProperty
{
    /** Should resolve to a string or array */
    protected mixed $property = null;

    /**
     * Set the property to be used, chainable.
     * 
     * @param string|\Closure $property
     * @return static
     */
    public function property(string|array|Closure $property): static
    {
        $this->setProperty($property);
        return $this;
    }

    /**
     * Set the property to be used quietly.
     * 
     * @param mixed $property
     * @return void
     */
    protected function setProperty(mixed $property): void
    {
        if (is_null($property)) return;
        $this->property = $property;
    }

    /**
     * Get the property to be used.
     * 
     * @return string|array
     */
    public function getProperty(): string|array|null
    {
        return $this->evaluate($this->property);
    }

    /**
     * Check if the class has a property
     * 
     * @return bool
     */
    public function hasProperty(): bool
    {
        return !is_null($this->property);
    }

    /**
     * Check if the class has an array of properties
     * 
     * @return bool
     */
    public function hasArrayOfProperties(): bool
    {
        return is_array($this->getProperty());
    }
}