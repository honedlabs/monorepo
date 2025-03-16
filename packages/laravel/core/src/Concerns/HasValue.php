<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasValue
{
    /**
     * The value for the instance.
     *
     * @var mixed
     */
    protected $value = null;

    /**
     * Set the value for the instance.
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
     * Get the value for the instance.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Determine if the instance has an value set.
     *
     * @return bool
     */
    public function hasValue()
    {
        return isset($this->value);
    }
}
