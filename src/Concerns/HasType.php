<?php

declare(strict_types=1);

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
     */
    public function type(string|Closure $type): static
    {
        $this->setType($type);

        return $this;
    }

    /**
     * Set the type property quietly.
     */
    public function setType(string|Closure|null $type): void
    {
        if (is_null($type)) {
            return;
        }
        $this->type = $type;
    }

    /**
     * Get the class type
     */
    public function getType(): ?string
    {
        return $this->evaluate($this->type);
    }

    /**
     * Check if the class has a type
     */
    public function hasType(): bool
    {
        return ! is_null($this->type);
    }

    /**
     * Check if the class does not have a type
     */
    public function lacksType(): bool
    {
        return ! $this->hasType();
    }
}
