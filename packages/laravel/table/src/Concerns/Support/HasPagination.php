<?php

declare(strict_types=1);

namespace Honed\Table\Concerns\Support;

use Honed\Table\PerPageRecord;

trait HasPagination
{
    use PagesKey;
    use RecordsKey;

    /**
     * The page options of the table if dynamic.
     *
     * @var array<int,\Honed\Table\PerPageRecord>
     */
    protected $pages = [];

    /**
     * Get records per page options.
     *
     * @return array<int,\Honed\Table\PerPageRecord>
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Create the record per page options for the table.
     *
     * @param  array<int,int>  $pagination
     * @param  int  $active
     * @return void
     */
    public function createRecordsPerPage($pagination, $active)
    {
        $this->pages = \array_map(
            static fn (int $amount) => PerPageRecord::make($amount, $active),
            $pagination
        );
    }

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
    public function getPagination()
    {
        if (isset($this->pagination)) {
            return $this->pagination;
        }

        if (\method_exists($this, 'pagination')) {
            return $this->pagination();
        }

        return $this->getFallbackPagination();
    }

    /**
     * Get the fallback pagination options for the table.
     *
     * @return int
     */
    protected function getFallbackPagination()
    {
        return type(config('table.pagination.default', 10))->asInt();
    }

    /**
     * Retrieve the default pagination options for the table.
     * 
     * @return int
     */
    public function getDefaultPagination()
    {
        if (isset($this->default)) {
            return $this->default;
        }

        return $this->getFallbackDefaultPagination();
    }

    /**
     * Get the fallback default pagination options for the table.
     *
     * @return int
     */
    protected function getFallbackDefaultPagination()
    {
        return type(config('table.pagination.default', 10))->asInt();
    }

    /**
     * Ensure that the pagination count is a valid option.
     * 
     * @param  int  $count
     * @param  array<int,int>  $options
     * @return void
     */
    protected function validateCount(&$count, $options)
    {
        if (\in_array($count, $options)) {
            return;
        }

        $count = $this->getDefaultPagination();
    }

    /**
     * Get the number of records to show per page.
     * 
     * @return int
     */
    protected function getCount()
    {
        $pagination = $this->getPagination();

        if (! \is_array($pagination)) {
            return $pagination;
        }

        $count = $this->getScopedQueryParameter(
            $this->getRecordsKey()
        );

        $this->validateCount($count, $pagination);
        $this->createRecordsPerPage($pagination, $count);

        return $count;
    }
}
