<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

trait HasPagination
{
    const PerPage = 10;

    /**
     * The pagination options for the table.
     * 
     * An array will provide the user the ability to select how many rows are
     * shown per page.
     * 
     * @var int|array<int,int>|null
     */
    protected $pagination;

    /**
     * The default pagination amount for the table if pagination is an array.
     * 
     * @var int|null
     */
    protected $defaultPagination;

    /**
     * Retrieve the pagination options for the table.
     * 
     * @return int|non-empty-list<int>
     */
    public function getPagination(): int|array
    {
        if (isset($this->pagination)) {
            return $this->pagination;
        }

        if (\method_exists($this, 'pagination')) {
            return $this->pagination();
        }

        /**
         * @var int|non-empty-list<int>
         */
        return config('table.pagination.default', 10);
    }

    /**
     * Retrieve the default pagination options for the table.
     * 
     * @return int
     */
    public function getDefaultPagination(): int
    {
        if (isset($this->defaultPagination)) {
            return $this->defaultPagination;
        }

        if (\method_exists($this, 'defaultPagination')) {
            return $this->defaultPagination();
        }

        /**
         * @var int
         */
        return config('table.pagination.default', 10);
    }
}