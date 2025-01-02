<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Transformable
{
    /**
     * @var (\Closure(mixed):mixed)|null
     */
    protected $transformer = null;

    /**
     * Set the transformation function for a given value, chainable.
     *
     * @template TArgs
     * @template TValue
     *
     * @param  \Closure(TArgs):TValue  $transformer
     * @return $this
     */
    public function transformer(\Closure $transformer): static
    {
        $this->setTransformer($transformer);

        return $this;
    }

    /**
     * Alias for `transformer`.
     *
     * @template TArgs
     * @template TValue
     *
     * @param  \Closure(TArgs):TValue  $transformer
     * @return $this
     */
    public function transformUsing(\Closure $transformer): static
    {
        return $this->transformer($transformer);
    }

    /**
     * Set the transformation function for a given value quietly.
     *
     * @template TArgs
     * @template TValue
     *
     * @param  \Closure(TArgs):TValue|null  $transformer
     */
    public function setTransformer(?\Closure $transformer): void
    {
        if (\is_null($transformer)) {
            return;
        }

        $this->transformer = $transformer;
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
        return $this->transformer;
    }

    /**
     * Determine if the class can transform a value.
     */
    public function canTransform(): bool
    {
        return ! \is_null($this->transformer);
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
