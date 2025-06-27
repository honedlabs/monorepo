<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait CanBeActive
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
     * Set the instance to be not be active.
     *
     * @return $this
     */
    public function notActive()
    {
        return $this->active(false);
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
     * Determine if the instance is not active.
     *
     * @return bool
     */
    public function isNotActive()
    {
        return ! $this->isActive();
    }
}
