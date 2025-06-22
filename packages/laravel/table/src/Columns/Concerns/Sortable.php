<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

use Closure;
use Honed\Refine\Sorts\Sort;

trait Sortable
{
    /**
     * The sortable state of the column.
     * 
     * @var bool|string|\Closure
     */
    protected $sortable = false;

    /**
     * Set the sortable state of the column.
     * 
     * @param  bool|string|\Closure  $sortable
     * @return $this
     */
    public function sortable($sortable = true)
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * Determine if the column is sortable.
     * 
     * @return bool
     */
    public function isSortable()
    {
        return (bool) $this->sortable;
    }

    /**
     * Get the sortable state of the column.
     * 
     * @return \Honed\Refine\Sort|null
     */
    public function getSort()
    {
        if (! $this->sortable) {
            return null;
        }

        $name = is_string($this->sortable) ? $this->sortable : $this->getName();

        return Sort::make($name, $this->getLabel())
            ->hidden()
            ->alias($this->getParameter())
            ->qualify($this->getQualifier())
            ->query($this->sortable instanceof Closure ? $this->sortable : null);
    }
}
