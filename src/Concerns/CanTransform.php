<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set a transform function on a class
 */
trait CanTransform
{
    protected Closure $transform = null;

    /**
     * Set the transformation function for a given value, chainable.
     * 
     * @param Closure $callback
     * @return static
     */
    public function transform(Closure $callback): static
    {
        $this->setTransform($callback);
        return $this;
    }


    /**
     * Set the transformation function for a given value quietly.
     * 
     * @param Closure $callback
     * @return void
     */
    protected function setTransform(Closure $callback): void
    {
        if (!$this->hasTransform()) return;
        $this->transform = $callback;
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
