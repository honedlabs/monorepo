<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasValue
{
    /**
     * The value of the instance.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Set the value of the instance.
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
     * Get the value of the instance.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
