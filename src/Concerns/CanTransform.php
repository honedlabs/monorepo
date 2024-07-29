<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set a transform function on a class
 */
trait CanTransform
{
    protected ?Closure $transform = null;

    /**
     * Set the transformation function for a given value, chainable.
     */
    public function transform(Closure $transform): static
    {
        $this->setTransform($transform);

        return $this;
    }

    /**
     * Set the transformation function for a given value quietly.
     */
    public function setTransform(?Closure $transform): void
    {
        if (is_null($transform)) {
            return;
        }
        $this->transform = $transform;
    }

    /**
     * Determine if the class has a transform.
     */
    public function canTransform(): bool
    {
        return ! is_null($this->transform);
    }

    /**
     * Determine if the class does not have a transform.
     */
    public function cannotTransform(): bool
    {
        return ! $this->canTransform();
    }

    /**
     * Alias for canTransform
     */
    public function hasTransform(): bool
    {
        return $this->canTransform();
    }

    /**
     * Apply the transformation to the given value.
     */
    public function transformUsing(mixed $value): mixed
    {
        if (! $this->hasTransform()) {
            return $value;
        }

        return $this->performTransform($value);
    }

    /**
     * Alias for transformUsing
     */
    public function applyTransform(mixed $value): mixed
    {
        return $this->transformUsing($value);
    }

    /**
     * Get the transformed value.
     */
    protected function performTransform(mixed $value): mixed
    {
        return ($this->transform)($value);
    }
}
