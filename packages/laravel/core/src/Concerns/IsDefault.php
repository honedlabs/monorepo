<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsDefault
{
    /**
     * @var bool
     */
    protected $default = false;

    /**
     * Set the instance as the default.
     *
     * @param bool $default The default state to set.
     * @return $this
     */
    public function default($default = true)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Determine if the instance is the default.
     * 
     * @return bool True if the instance is the default, false otherwise.
     */
    public function isDefault()
    {
        return $this->default;
    }
}
