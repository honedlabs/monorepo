<?php

namespace Honed\Refine\Contracts;

/**
 * @phpstan-require-extends \Honed\Core\Primitive
 */
interface RefinesData extends FiltersData, SortsData, SearchesData
{
    /**
     * Get the callback to be executed before the refiners.
     *
     * @return \Closure|null
     */
    public function getBeforeCallback();

    /**
     * Get the callback to be executed after refinement.
     *
     * @return \Closure|null
     */
    public function getAfterCallback();
}