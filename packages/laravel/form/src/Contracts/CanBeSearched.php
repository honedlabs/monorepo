<?php

declare(strict_types=1);

namespace Honed\Form\Contracts;

use Honed\Form\Data\SearchData;

interface CanBeSearched
{
    /**
     * Convert the class to a search data instance.
     */
    public function toSearchData(): SearchData;
}
