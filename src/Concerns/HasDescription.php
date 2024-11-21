<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Honed\Core\Attributes\Description;
use ReflectionClass;

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
        return $this->evaluate($this->description) ?? $this->evaluateDescriptionAttribute();
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

    /**
     * Evaluate the description attribute if present
     */
    protected function evaluateDescriptionAttribute(): ?string
    {
        $attributes = (new ReflectionClass($this))->getAttributes(Description::class);

        if (! empty($attributes)) {
            return $attributes[0]->newInstance()->getDescription();
        }

        return null;
    }
}
