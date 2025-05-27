<?php

namespace Honed\Core\Concerns;

trait IsDefault
{
    /**
     * Whether it is the default.
     *
     * @var bool
     */
    protected $default = false;

    /**
     * Set as the default.
     *
     * @param  bool  $default
     * @return $this
     */
    public function default($default = true)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Determine if it is the default.
     *
     * @return bool
     */
    public function isDefault()
    {
        return $this->default;
    }
}
