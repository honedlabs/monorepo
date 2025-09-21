<?php

declare(strict_types=1);

namespace Honed\Author\Scopes;

use Honed\Author\Support\Author;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CreatedByScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  Builder<TModel>  $builder
     * @param  TModel&\Honed\Author\Contracts\Authorable  $model
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where($model->getQualifiedCreatedByColumn(), Author::identifier());
    }
}
