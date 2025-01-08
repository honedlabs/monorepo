<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasValue
{
    /**
     * @var mixed
     */
    protected $value = null;

    /**
     * Get or set the value for the instance.
     * 
     * @param mixed $value The value to set, or null to retrieve the current value.
     * @return mixed|$this The current value when no argument is provided, or the instance when setting the value.
     */
    public function value($value = null)
    {
        if (\is_null($value)) {
            return $this->value;
        }

        $this->value = $value;

        return $this;
    }

    /**
     * Determine if the instance has an value set.
     * 
     * @return bool True if an value is set, false otherwise.
     */
    public function hasValue()
    {
        return ! \is_null($this->value);
    }
}
