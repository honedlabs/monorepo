<?php

namespace Honed\Table\Concerns;

use Honed\Table\Contracts\ShouldSelect;

trait Selectable
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
     * @param  bool|array<int, string>  $select
     * @return $this
     */
    public function selectable($select = true)
    {
        $this->selectable = $select;

        return $this;
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
     * Get the columns to select.
     *
     * @return array<int, string>
     */
    public function getSelectableColumns()
    {
        return is_array($this->selectable) ? $this->selectable : [];
    }
}