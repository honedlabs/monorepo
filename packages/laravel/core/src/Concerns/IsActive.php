<?php

namespace Honed\Core\Concerns;

trait IsActive
{
    /**
     * Whether it is active.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * Set as active.
     *
     * @param  bool  $active
     * @return $this
     */
    public function active($active = true)
    {
        $this->active = $active;

        return $this;
    }

    public function inactive($inactive = true)
    {
        $this->active = ! $inactive;

        return $this;
    }

    /**
     * Determine if it is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }
}
