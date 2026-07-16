<?php

declare(strict_types=1);

namespace Honed\Bind\Concerns;

use Honed\Bind\Binder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasBinder
{
    /**
     * Get the binder for the model.
     */
    public static function binder(?string $field): ?Binder
    {
        return static::getBinder($field);
    }

    /**
     * Get a model using the specified binding.
     *
     * @return static|null
     */
    public static function firstBound(?string $field = null, mixed $value = null): ?Model
    {
        $field ??= 'default';

        return static::binder($field)
            ?->resolve(static::query(), $value, $field);
    }

    /**
     * Scope the query using the specified binding.
     *
     * @return Builder<static>
     */
    public static function whereBound(?string $field = null, mixed $value = null): Builder
    {
        $field ??= 'default';

        $query = static::query();

        return static::binder($field)?->query($query, $value, $field) ?? $query;
    }

    /**
     * Get models using the specified binding.
     *
     * @return Collection<int, $this>
     */
    public static function getBound(?string $field = null, mixed $value = null): Collection
    {
        return static::whereBound($field, $value)->get();
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($binder = static::getBinder($field ?? 'default')) {
            return $binder->resolve($this, $value, $field ?? 'default');
        }

        return parent::resolveRouteBinding($value, $field);
    }

    /**
     * Get the binder for the model.
     */
    protected static function getBinder(?string $field): ?Binder
    {
        return Binder::for(static::class, $field);
    }
}
