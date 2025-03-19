<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasValue
{
    /**
     * The value.
     *
     * @var mixed
     */
    protected $value = null;

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
        return isset($this->value);
    }
}
