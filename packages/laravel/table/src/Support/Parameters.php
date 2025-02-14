<?php

declare(strict_types=1);

namespace Honed\Table\Support;

// Needs to extend a contract
class Parameters
{
    /**
     * 
     */
    const ColumnsKey = 'columns';

    /**
     * 
     */
    const PagesKey = 'page';

    /**
     * 
     */
    const RecordsKey = 'rows';

    /**
     * 
     */
    const SortsKey = 'sorts';

    /**
     * 
     */
    const SearchesKey = 'searches';

    /**
     * 
     */
    const FiltersKey = 'filters';

    /**
     * 
     */
    const Pagination = 10;

    /**
     * 
     */
    const DefaultPagination = 10;

    /**
     * 
     */
    const Paginator = 'length-aware';

    /**
     * 
     */
    const Duration = 10;

    /**
     * 
     */
    const DefaultDuration = 10;

    /**
     * 
     */
    const Endpoint = '/actions';
}