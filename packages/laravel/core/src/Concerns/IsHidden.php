<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsHidden
{
    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * Set the instance as hidden.
     *
     * @param bool $hidden The hidden state to set.
     * @return $this
     */
    public function hidden($hidden = true)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Alias for `hidden`.
     *
     * @param bool $hide The hidden state to set.
     * @return $this
     */
    public function hide($hide = true)
    {
        return $this->hidden($hide);
    }

    /**
     * Set the instance as shown.
     *
     * @param bool $show The show state to set.
     * @return $this
     */
    public function shown($shown = true)
    {
        return $this->hidden(! $shown);
    }

    /**
     * Alias for `shown`.
     *
     * @param bool $show The show state to set.
     * @return $this
     */
    public function show($show = true)
    {
        return $this->shown($show);
    }

    /**
     * Determine if the instance is hidden.
     * 
     * @return bool True if the instance is hidden, false otherwise.
     */
    public function isHidden()
    {
        return $this->hidden;
    }
}
