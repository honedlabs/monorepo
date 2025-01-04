<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

use Honed\Table\Sorts\Sort;

/**
 * @mixin \Honed\Core\Concerns\HasName
 */
trait IsSortable
{
    /**
     * @var bool|string
     */
    protected $sortable = false;

    /**
     * @var \Honed\Table\Sorts\Contracts\Sort|null
     */
    protected $sort;

    /**
     * Set the sortable property, chainable.
     *
     * @param  bool|non-empty-string|null  $sortable
     * @return $this
     */
    public function sortable(bool|string|null $sortable = true): static
    {
        $this->setSortable($sortable);

        return $this;
    }

    /**
     * Set the sortable property quietly.
     *
     * @param  bool|non-empty-string|null  $sortable
     */
    public function setSortable(bool|string|null $sortable): void
    {
        if (\is_null($sortable)) {
            return;
        }

        $sortName = \is_string($sortable) 
            ? $sortable 
            : $this->getName();

        $this->sort = Sort::make($sortName)->agnostic();
        $this->sortable = (bool) $sortable;
    }

    /**
     * Determine if the column is sortable.
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * Get the sort instance.
     */
    public function getSort(): ?Sort
    {
        return $this->sort;
    }
}
