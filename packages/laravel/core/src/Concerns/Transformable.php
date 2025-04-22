<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Transformable
{
    /**
     * The transformer function.
     *
     * @default null
     *
     * @var \Closure(mixed):mixed|null
     */
    protected $transformer = null;

    /**
     * Set the transformer function.
     *
     * @param  \Closure(mixed):mixed  $transformer
     * @return $this
     */
    public function transformer($transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Define the transformer function.
     *
     * @return \Closure(mixed):mixed|null
     */
    public function defineTransformer()
    {
        return null;
    }

    /**
     * Get the transformer function.
     *
     * @return \Closure(mixed):mixed|null
     */
    public function getTransformer()
    {
        return $this->transformer ??= $this->defineTransformer();
    }

    /**
     * Determine if a transformer function is set.
     *
     * @return bool
     */
    public function transforms()
    {
        return filled($this->getTransformer());
    }

    /**
     * Transform the argument using the transformer function.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function transform($value)
    {
        $transformer = $this->getTransformer();

        if (! $transformer) {
            return $value;
        }

        return $transformer($value);
    }
}
