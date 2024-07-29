<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Closure;

trait HasDescription
{
    protected string|Closure|null $description = null;

    /**
     * Set the description, chainable.
     */
    public function description(string|Closure $description): static
    {
        $this->setDescription($description);

        return $this;
    }

    /**
     * Set the description quietly.
     */
    public function setDescription(string|Closure|null $description): void
    {
        if (is_null($description)) {
            return;
        }
        $this->description = $description;
    }

    /**
     * Get the description
     */
    public function getDescription(): ?string
    {
        return $this->evaluate($this->description);
    }

    /**
     * Determine if the class does not have a description.
     */
    public function lacksDescription(): bool
    {
        return is_null($this->description);
    }

    /**
     * Determine if the class has a description.
     */
    public function hasDescription(): bool
    {
        return ! $this->lacksDescription();
    }
}
