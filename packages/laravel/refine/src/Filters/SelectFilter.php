<?php

declare(strict_types=1);

namespace Honed\Refine\Filters;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Filters\Filter<TModel, TBuilder>
 */
class SelectFilter extends Filter
{
    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->multiple();
    }

    /**
     * Define the type of the filter.
     *
     * @return string
     */
    public function type()
    {
        return 'select';
    }
}
