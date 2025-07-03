<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait Transformable
{
    /**
     * The transformer function.

     *
     * @var Closure():mixed|null
     */
    protected $transformer;

    /**
     * Set the transformer function.
     *
     * @param  Closure():mixed  $transformer
     * @return $this
     */
    public function transformer(?Closure $transformer): static
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Get the transformer function.
     *
     * @return Closure():mixed|null
     */
    public function getTransformer(): ?Closure
    {
        return $this->transformer;
    }

    /**
     * Determine if a transformer function is set.
     */
    public function transforms(): bool
    {
        return isset($this->transformer);
    }

    /**
     * Transform the argument using the transformer function.
     */
    public function transform(mixed $value): mixed
    {
        $transformer = $this->getTransformer();

        if (! $transformer) {
            return $value;
        }

        return $transformer($value);
    }
}
