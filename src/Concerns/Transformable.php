<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Transformable
{
    /**
     * @var (\Closure(mixed):mixed)|null
     */
    protected $transform = null;

    /**
     * Set the transformation function for a given value, chainable.
     * 
     * @template T
     * @param \Closure(T):mixed $transform
     * @return $this
     */
    public function transform(\Closure $transform): static
    {
        $this->setTransform($transform);

        return $this;
    }

    /**
     * Alias for transform
     * 
     * @template T
     * @param \Closure(T):mixed $transform
     * @return $this
     */
    public function transformUsing(\Closure $transform): static
    {
        return $this->transform($transform);
    }

    /**
     * Set the transformation function for a given value quietly.
     * 
     * @template T
     * @param \Closure(T):mixed|null $transform
     */
    public function setTransform(?\Closure $transform): void
    {
        if (is_null($transform)) {
            return;
        }
        $this->transform = $transform;
    }

    /**
     * Get the transformation function.
     * 
     * @template T
     * @return (\Closure(T):mixed)|null
     */
    public function getTransform(): ?\Closure
    {
        return $this->transform;
    }

    /**
     * Determine if the class cannot transform a value.
     */
    public function cannotTransform(): bool
    {
        return \is_null($this->transform);
    }

    /**
     * Determine if the class can transform a value.
     */
    public function canTransform(): bool
    {
        return ! $this->cannotTransform();
    }


    /**
     * Apply the transformation function to a value.
     * 
     * @template T
     * @param T $value
     * @return mixed|T
     */
    public function applyTransform(mixed $value)
    {
        if ($this->cannotTransform()) {
            return $value;
        }

        return ($this->getTransform())($value);
    }
}
