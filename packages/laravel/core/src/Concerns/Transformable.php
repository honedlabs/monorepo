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
     * @param \Closure|bool $transformer The transformer function to be set.
     * @return $this
     */
    public function transformer($transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Determine if the instance has a transformer function set.
     * 
     * @return bool True if a transformer function is set, false otherwise.
     */
    public function transforms(): bool
    {
        return ! \is_null($this->transformer);
    }

    /**
     * Transform the argument using the transformer function.
     * 
     * @param mixed $value The value to transform.
     * @return mixed The transformed value.
     */
    public function transform($value)
    {
        return $this->transforms() 
            ? \call_user_func($this->transformer, $value) 
            : $value;
    }
}
