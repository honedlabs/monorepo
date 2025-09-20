<?php

declare(strict_types=1);

namespace Honed\Table\Pagination;

class CursorData extends PaginationData
{
    /**
     * The url of the previous page.
     * 
     * @var string|null
     */
    protected $prevLink;

    /**
     * The url of the next page.
     * 
     * @var string|null
     */
    protected $nextLink;

    /**
     * The number of records per page.
     * 
     * @var int
     */
    protected $perPage;
}