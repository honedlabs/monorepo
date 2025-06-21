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
     * Determine if the instance is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }
}
