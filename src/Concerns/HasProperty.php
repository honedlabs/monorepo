<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Honed\Core\Attributes\Property;
use ReflectionClass;

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
     * @param  string|\Closure  $property
     */
    public function property(string|array|Closure $property): static
    {
        $this->setProperty($property);

        return $this;
    }

    /**
     * Set the property to be used quietly.
     */
    public function setProperty(mixed $property): void
    {
        if (is_null($property)) {
            return;
        }
        $this->property = $property;
    }

    /**
     * Get the property to be used.
     */
    public function getProperty(): string|array|null
    {
        return $this->evaluate($this->property) ?? $this->evaluatePropertyAttribute();
    }

    /**
     * Check if the class has a property
     */
    public function hasProperty(): bool
    {
        return ! is_null($this->property);
    }

    /**
     * Check if the class does not have a property
     */
    public function lacksProperty(): bool
    {
        return ! $this->hasProperty();
    }

    /**
     * Check if the class has an array of properties
     */
    public function isPropertyArray(): bool
    {
        return is_array($this->getProperty());
    }

    /**
     * Evaluate the property attribute if present
     */
    protected function evaluatePropertyAttribute(): ?string
    {
        $attributes = (new ReflectionClass($this))->getAttributes(Property::class);

        if (! empty($attributes)) {
            return $attributes[0]->newInstance()->getProperty();
        }

        return null;
    }
}
