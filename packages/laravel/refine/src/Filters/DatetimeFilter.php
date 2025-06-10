<?php

declare(strict_types=1);

namespace Honed\Refine\Filters;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Filters\Filter<TModel, TBuilder>
 */
class DatetimeFilter extends Filter
{
    public function type()
    {
        return 'datetime';
    }

    public function setUp()
    {
        parent::setUp();

        $this->as('datetime');
    }
}
