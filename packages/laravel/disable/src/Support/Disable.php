<?php

declare(strict_types=1);

namespace Honed\Disable\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class Disable
{
    /**
     * Apply the disable scope to the builder.
     *
     * @param  Builder<Model>  $builder
     * @param  \Honed\Disable\Contracts\Disableable&Model  $model
     */
    public static function builder(Builder $builder, Model $model, bool $value): void
    {
        $query = $builder->getQuery();

        match (true) {
            self::boolean() && $column = $model->getDisabledColumn() => 
                $query->where($builder->qualifyColumn($column), $value),
            self::timestamp() && $column = $model->getDisabledAtColumn() => 
                $value
                    ? $query->whereNotNull($builder->qualifyColumn($column))
                    : $query->whereNull($builder->qualifyColumn($column)),
            self::user() && $column = $model->getDisabledByColumn() => 
                $value
                    ? $query->whereNotNull($builder->qualifyColumn($column))
                    : $query->whereNull($builder->qualifyColumn($column)),
        };

    }

    /**
     * Get the boolean config value.
     */
    public static function boolean(): bool
    {
        return (bool) config('disable.boolean', false);
    }

    /**
     * Get the timestamp config value.
     */
    public static function timestamp(): bool
    {
        return (bool) config('disable.timestamp', false);
    }

    /**
     * Get the user config value.
     */
    public static function user(): bool
    {
        return (bool) config('disable.user', false);
    }
}
