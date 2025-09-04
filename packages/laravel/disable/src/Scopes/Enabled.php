<?php

declare(strict_types=1);

namespace Honed\Disable\Scopes;

use Honed\Disable\Contracts\Disableable;
use Honed\Disable\Support\Disable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class Enabled implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model&\Honed\Disable\Contracts\Disableable
     *
     * @param  \Illuminate\Database\Eloquent\Builder<TModel>  $builder
     * @param  TModel  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        Disable::builder($builder, $model, false);
    }
}