<?php

declare(strict_types=1);

namespace Honed\Disable\Scopes;

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
     * @param \Illuminate\Database\Eloquent\Builder<TModel> $builder
     * @param TModel $model
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->getQuery()->where($builder->qualifyColumn($model->getDisabledAttribute()), false);
    }
}