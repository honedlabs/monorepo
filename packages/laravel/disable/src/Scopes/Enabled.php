<?php

declare(strict_types=1);

namespace Honed\Disable\Scopes;

use Honed\Disable\Contracts\Disableable;
use Honed\Disable\Support\Disable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Enabled implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  Builder<TModel>  $builder
     * @param  TModel&Disableable  $model
     */
    public function apply(Builder $builder, Model $model): void
    {
        Disable::builder($builder, $model, false);
    }
}
