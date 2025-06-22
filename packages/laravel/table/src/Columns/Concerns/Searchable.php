<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

/**
 * @phpstan-require-extends \Honed\Table\Columns\Column
 */
trait Searchable
{
    /**
     * The searchable state of the column.
     * 
     * @var bool|string|array<int,string>
     */
    protected $searchable = false;

    /**
     * Set the searchable state of the column.
     * 
     * @param  bool|string|array<int,string>  $searches
     * @return $this
     */
    public function searchable($searches = true)
    {
        $this->searchable = $searches;

        return $this;
    }

    /**
     * Determine if the column is searchable.
     * 
     * @return bool
     */
    public function isSearchable()
    {
        return (bool) $this->searchable;
    }
}
