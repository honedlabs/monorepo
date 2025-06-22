<?php

declare(strict_types=1);

namespace Honed\Refine\Contracts;

use Honed\Core\Concerns\HasRequest;

interface FiltersData 
{
    /**
     * Retrieve the filters.
     *
     * @return array<int,Filter>
     */
    public function getFilters();

    /**
     * Get the store to use for persisting filters.
     *
     * @return \Honed\Refine\Stores\Store|null
     */
    public function getFilterStore();

    /**
     * Determine if the filter should be persisted.
     *
     * @return bool
     */
    public function shouldPersistFilter();
}
