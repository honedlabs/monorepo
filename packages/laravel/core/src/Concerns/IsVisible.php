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
     * Set as visible, chainable.
     *
     * @param bool $visible The visible state to set.
     * @return $this
     */
    public function visible($visible = true)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Set as invisible, chainable.
     *
     * @param bool $invisible The invisible state to set.
     * @return $this
     */
    public function invisible($invisible = true)
    {
        return $this->visible(! $invisible);
    }

    /**
     * Determine if the instance is visible.
     * 
     * @return bool True if the instance is visible, false otherwise.
     */
    public function isVisible()
    {
        return $this->visible;
    }
}
