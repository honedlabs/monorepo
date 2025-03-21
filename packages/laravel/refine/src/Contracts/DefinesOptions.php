<?php

declare(strict_types=1);

namespace Honed\Refine\Contracts;

interface DefinesOptions
{
    /**
     * Define the options to be supplied by the refinement.
     * 
     * @return array<int, \Honed\Refine\Option>
     */
    public function usingOptions();

    /**
     * Define whether the refinement should be restricted to only the defined
     * options.
     * 
     * @return bool
     */
    public function restrictToOptions();

    /**
     * Define whether multiple options are allowed.
     * 
     * @return bool
     */
    public function allowsMultiple();
}