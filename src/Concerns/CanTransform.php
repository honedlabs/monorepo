<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Closure;

/**
 * @deprecated Use Transforms trait instead
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
     * Alias for transform
     */
    public function transformUsing(Closure $transform): static
    {
        return $this->transform($transform);
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

    public function getTransform(): ?Closure
    {
        return $this->transform;
    }

    public function applyTransform(mixed $value): mixed
    {
        if ($this->cannotTransform()) {
            return $value;
        }

        return $this->performTransform($value);
    }

    protected function performTransform(mixed $value): mixed
    {
        return ($this->getTransform())($value);
    }
}
