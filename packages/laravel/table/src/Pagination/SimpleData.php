<?php

declare(strict_types=1);

namespace Honed\Table\Pagination;

class SimpleData extends CursorData
{
    /**
     * The current page.
     * 
     * @var int
     */
    protected $currentPage;
}