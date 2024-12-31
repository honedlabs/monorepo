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
     * @template TArgs
     * @template TValue
     *
     * @param  \Closure(TArgs):TValue  $transform
     * @return $this
     */
    public function transformer(\Closure $transform): static
    {
        $this->setTransform($transform);

        return $this;
    }

    /**
     * Alias for transform
     *
     * @template TArgs
     * @template TValue
     *
     * @param  \Closure(TArgs):TValue  $transform
     * @return $this
     */
    public function transformUsing(\Closure $transform): static
    {
        return $this->transformer($transform);
    }

    /**
     * Set the transformation function for a given value quietly.
     *
     * @template TArgs
     * @template TValue
     *
     * @param  \Closure(TArgs):TValue|null  $transform
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
     * @template TArgs
     * @template TValue
     *
     * @return (\Closure(TArgs):TValue)|null
     */
    public function getTransformer(): ?\Closure
    {
        return $this->transform;
    }

    /**
     * Determine if the class can transform a value.
     */
    public function canTransform(): bool
    {
        return ! \is_null($this->transform);
    }

    /**
     * Apply the transformation function to a value.
     *
     * @template TArgs
     * @template TValue
     *
     * @param  TArgs  $value
     * @return TValue
     */
    public function transform(mixed $value)
    {
        return $this->canTransform() ? \call_user_func($this->getTransformer(), $value) : $value;
    }
}
