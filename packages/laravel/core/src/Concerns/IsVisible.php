<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsVisible
{
    /**
     * @var bool
     */
    protected $visible = true;

    /**
     * Set the instance as visible.
     *
     * @param  bool  $visible
     * @return $this
     */
    public function visible($visible = true)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Set the instance as invisible.
     *
     * @param  bool  $invisible
     * @return $this
     */
    public function invisible($invisible = true)
    {
        return $this->visible(! $invisible);
    }

    /**
     * Determine if the instance is visible.
     *
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }
}
