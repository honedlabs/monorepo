<?php

namespace Honed\Core\Concerns;

trait HasValue
{
    /**
     * The value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Set the value.
     *
     * @param  mixed  $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Determine if the value is set.
     *
     * @return bool
     */
    public function hasValue()
    {
        return filled($this->getValue());
    }
}
