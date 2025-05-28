<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @method TBuilder|void queryUsing(TBuilder $builder, mixed ...$values) Define the query.
 */
interface WithQuery
{
    //
}
