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
     * @param \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder
     * @param \Honed\Disable\Contracts\Disableable $model
     */
    public static function builder(Builder $builder, Model $model, bool $value): void
    {
        $query = $builder->getQuery();

        if (self::boolean()) {
            $query->where($builder->qualifyColumn($model->getDisabledColumn()), $value);
        }

        if (self::timestamp()) {
            $value 
                ? $query->whereNotNull($builder->qualifyColumn($model->getDisabledAtColumn()))
                : $query->whereNull($builder->qualifyColumn($model->getDisabledAtColumn()));
        }

        if (self::user()) {
            $value
                ? $query->whereNotNull($builder->qualifyColumn($model->getDisabledByColumn()))
                : $query->whereNull($builder->qualifyColumn($model->getDisabledByColumn()));
        }
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