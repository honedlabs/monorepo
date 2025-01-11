<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Transformable
{
    /**
     * @var \Closure|null
     */
    protected $transformer = null;

    /**
     * Set the transformer function for the instance.
     *
     * @return $this
     */
    public function transformer(\Closure $transformer): static
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Determine if the instance has a transformer function set.
     */
    public function transforms(): bool
    {
        return ! \is_null($this->transformer);
    }

    /**
     * Transform the argument using the transformer function.
     */
    public function transform(mixed $value): mixed
    {
        return $this->transforms()
            ? \call_user_func($this->transformer, $value)
            : $value;
    }
}
