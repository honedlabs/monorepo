<?php

declare(strict_types=1);

namespace Honed\Author\Scopes;

use Honed\Author\Support\Author;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Honed\Disable\Contracts\Disableable;
use Illuminate\Database\Eloquent\Builder;

class UpdatedByScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  Builder<TModel>  $builder
     * @param  TModel&\Honed\Author\Concerns\Authorable  $model
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where($model->getQualifiedUpdatedByColumn(), Author::identifier());
    }
}