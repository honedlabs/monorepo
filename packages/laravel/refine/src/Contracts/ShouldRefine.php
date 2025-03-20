<?php

declare(strict_types=1);

namespace Honed\Refine\Contracts;

interface ShouldRefine
{
    /**
     * Determine if the model should be refined.
     *
     * @return array<int, \Honed\Refine\Sort<TModel, TBuilder>>
     */
    public function sorts();

    public function searches();

    public function filters();

    
}