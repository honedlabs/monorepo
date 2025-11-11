<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Data\SearchData;

/**
 * @phpstan-require-implements \Honed\Form\Contracts\CanBeSearched
 */
trait CanBeSearched
{
    /**
     * Convert the class to a search data instance.
     */
    public function toSearchData(): SearchData
    {
        return SearchData::from($this);
    }
}