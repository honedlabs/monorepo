<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsHidden
{
    /**
     * Whether it is hidden.
     *
     * @var bool
     */
    protected $hidden = false;

    /**
     * Set as hidden.
     *
     * @param  bool  $hidden
     * @return $this
     */
    public function hidden($hidden = true)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Set as shown.
     *
     * @param  bool  $shown
     * @return $this
     */
    public function shown($shown = true)
    {
        return $this->hidden(! $shown);
    }

    /**
     * Determine if it is hidden.
     *
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }
}
