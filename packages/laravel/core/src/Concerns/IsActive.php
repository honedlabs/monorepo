<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsActive
{
    /**
     * Whether it is active.
     *
     * @default false
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
     * Determine if it is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }
}
