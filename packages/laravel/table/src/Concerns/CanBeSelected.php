<?php

namespace Honed\Table\Concerns;

use Honed\Table\Contracts\ShouldSelect;

trait CanBeSelected
{
    /**
     * The columns to select, indicative of whether the instance is selectable.
     * 
     * @param bool|array<int, string> $selectable
     */
    protected $selectable = false;

    /**
     * Set the instance to be selectable, optionally with a list of columns to select.
     *
     * @param  bool|array<int, string>  $enable
     * @return $this
     */
    public function selectable($enable = true)
    {
        $this->selectable = $enable;

        return $this;
    }

    /**
     * Set the instance to not be selectable.
     * 
     * @param  bool  $disable
     * @return $this
     */
    public function notSelectable($disable = true)
    {
        return $this->selectable(! $disable);
    }


    /**
     * Determine if the instance is selectable.
     *
     * @return bool
     */
    public function isSelectable()
    {
        return ((bool) $this->selectable) || $this instanceof ShouldSelect;
    }

    /**
     * Determine if the instance is not selectable.
     *
     * @return bool
     */
    public function isNotSelectable()
    {
        return ! $this->isSelectable();
    }

    /**
     * Get the columns to select.
     *
     * @return array<int, string>
     */
    public function getSelectableColumns()
    {
        return is_array($this->selectable) ? $this->selectable : [];
    }
}