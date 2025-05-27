<?php

namespace Honed\Core\Concerns;

use Closure;
use Honed\Core\Contracts\WithTransformer;

trait Transformable
{
    /**
     * The transformer function.
     *
     * @default null
     *
     * @var Closure(mixed):mixed|null
     */
    protected $transformer = null;

    /**
     * Set the transformer function.
     *
     * @param  Closure(mixed):mixed  $transformer
     * @return $this
     */
    public function transformer($transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Get the transformer function.
     *
     * @return Closure(mixed):mixed|null
     */
    public function getTransformer()
    {
        if (isset($this->transformer)) {
            return $this->transformer;
        }

        if ($this instanceof WithTransformer) {
            return $this->transformer = Closure::fromCallable([$this, 'transformUsing']);
        }

        return null;
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
