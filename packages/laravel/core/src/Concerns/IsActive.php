<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsActive
{
    /**
     * Whether the instance is active.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * Set the instance to active.
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
     * Set the instance to inactive.
     *
     * @param  bool  $inactive
     * @return $this
     */
    public function inactive($inactive = true)
    {
        return $this->active(! $inactive);
    }

    /**
     * Determine if the instance is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Determine if the instance is inactive.
     *
     * @return bool
     */
    public function isInactive()
    {
        return ! $this->isActive();
    }
}
