<?php

declare(strict_types=1);

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

    /**
     * Set as inactive.
     *
     * @param  bool  $inactive
     * @return $this
     */
    public function inactive($inactive = true)
    {
        return $this->active(! $inactive);
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
