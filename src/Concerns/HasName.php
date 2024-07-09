<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set a name property on a class
 */
trait HasName
{
    protected string|Closure|null $name = null;

    /**
     * Set the name, chainable.
     */
    public function name(string|Closure $name): static
    {
        $this->setName($name);

        return $this;
    }

    /**
     * Set the name quietly.
     */
    public function setName(string|Closure|null $name): void
    {
        if (is_null($name)) {
            return;
        }
        $this->name = $name;
    }

    /**
     * Get the name
     *
     * @return string|Closure
     */
    public function getName(): ?string
    {
        return $this->evaluate($this->name);
    }

    /**
     * Convert a string to the name format
     */
    public function toName(string|Closure $label): string
    {
        return str($this->evaluate($label))->snake()->lower();
    }

    /**
     * Check if the class has a name
     */
    public function hasName(): bool
    {
        return ! is_null($this->getName());
    }

    /**
     * Check if the class lacks a name
     */
    public function lacksName(): bool
    {
        return ! $this->hasName();
    }
}
