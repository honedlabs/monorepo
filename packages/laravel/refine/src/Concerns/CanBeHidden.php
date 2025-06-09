<?php

namespace Honed\Refine\Concerns;

trait CanBeHidden
{
    /**
     * Whether the instance should be serialized.
     * 
     * @var bool
     */
    protected $hidden = false;

    /**
     * Set whether the instance should be hidden from serialization
     *
     * @param bool $hidden
     * @return $this
     */
    public function hidden($hidden = true)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Set whether the instance should not be hidden from serialization.
     * 
     * @param bool $hidden
     * @return $this
     */
    public function visible($visible = true)
    {
        return $this->hidden(! $visible);
    }

    /**
     * Get whether the instance should be hidden from serialization.
     *
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * Get whether the instance should be shown when serializing.
     * 
     * @return bool
     */
    public function isVisible()
    {
        return ! $this->isHidden();
    }
}