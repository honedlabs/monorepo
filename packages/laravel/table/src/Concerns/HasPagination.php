<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Page;
use Honed\Table\Concerns\Keys\PagesKey;
use Honed\Table\Concerns\Keys\RecordsKey;

trait HasPagination
{
    use HasPages;
    use RecordsKey;
    use PagesKey;
    
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
    protected $default;

    /**
     * Retrieve the pagination options for the table.
     * 
     * @return int|array<int,int>
     */
    public function getPagination(): int|array
    {
        if (isset($this->pagination)) {
            return $this->pagination;
        }

        if (\method_exists($this, 'pagination')) {
            return $this->pagination();
        }

        /** @var int|array<int,int> */
        return config('table.pagination.default', 10);
    }

    /**
     * Retrieve the default pagination options for the table.
     * 
     * @return int
     */
    public function getDefault(): int
    {
        if (isset($this->default)) {
            return $this->default;
        }

        /** @var int */
        return config('table.pagination.default', 10);
    }

    /**
     * Get the number of records to show per page.
     */
    protected function getRecordsPerPage(): int
    {
        $paginationOptions = $this->getPagination();
        
        if (! \is_array($paginationOptions)) {
            return $paginationOptions;
        }

        $perPage = $this->getRecordsFromRequest();
        $default = $this->getDefault();

        $validPerPage = \in_array($perPage, $paginationOptions) ? $perPage : $default;
        $this->pages = $this->generatePages($paginationOptions, $validPerPage);

        return $validPerPage;
    }

    /**
     * Get the number of records to show per page from the request.
     */
    protected function getRecordsFromRequest(): int
    {
        /**
         * @var \Illuminate\Http\Request
         */
        $request = $this->getRequest();

        return $request->integer(
            $this->getRecordsKey(),
            $this->getDefault(),
        );
    }
}