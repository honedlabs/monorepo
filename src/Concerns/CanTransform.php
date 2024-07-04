<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set a transform function on a class
 */
trait CanTransform
{
    protected Closure|null $transform = null;

    /**
     * Set the transformation function for a given value, chainable.
     * 
     * @param Closure $transform
     * @return static
     */
    public function transform(Closure $transform): static
    {
        $this->setTransform($transform);
        return $this;
    }

    /**
     * Set the transformation function for a given value quietly.
     * 
     * @param Closure $transform
     * @return void
     */
    public function setTransform(Closure|null $transform): void
    {
        if (is_null($transform)) return;
        $this->transform = $transform;
    }

    /**
     * Determine if the class has a transform.
     * 
     * @return bool
     */
    public function canTransform(): bool
    {
        return !is_null($this->transform);
    }

    public function cannotTransform(): bool
    {
        return !$this->canTransform();
    }

    /**
     * Alias for canTransform
     * 
     * @return bool
     */
    public function hasTransform(): bool
    {
        return $this->canTransform();
    }

    /**
     * Apply the transformation to the given value.
     * 
     * @param mixed $value
     * @return mixed
     */
    public function transformUsing(mixed $value): mixed
    {
        if (!$this->hasTransform()) return $value;
        return $this->performTransform($value);
    }

    /**
     * Alias for transformUsing
     * 
     * @param mixed $value
     * @return mixed
     */
    public function applyTransform(mixed $value): mixed
    {
        return $this->transformUsing($value);
    }

    /**
     * Get the transformed value.
     * 
     * @param mixed $value
     * @return mixed
     */
    protected function performTransform(mixed $value): mixed
    {
        return ($this->transform)($value);
    }
}
