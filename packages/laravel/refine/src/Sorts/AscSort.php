<?php

declare(strict_types=1);

namespace Honed\Refine\Sorts;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Sorts\Sort<TModel, TBuilder>
 */
class AscSort extends Sort
{
    /**
     * Define the type of the sort.
     *
     * @return string
     */
    public function type()
    {
        return 'sort:asc';
    }

    /**
     * Provide the instance with any necessary setup.
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->descending();
    }
}
