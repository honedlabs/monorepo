<?php

declare(strict_types=1);

namespace Honed\Bind\Concerns;

use Honed\Bind\Binder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use UnexpectedValueException;

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

        if (! $binder = static::binder($field)) {
            return $query;
        }

        $bound = $binder->query($query, $value, $field);

        if (! $bound instanceof Builder) {
            throw new UnexpectedValueException("Binding [{$field}] must return an eloquent builder.");
        }

        return $bound;
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
     * Retrieve the query for a bound value.
     *
     * Laravel passes the already-scoped query: the model for a normal binding,
     * or the parent relation for a child binding. Soft-deleted binding appends
     * `withTrashed()` to the query returned here.
     *
     * @param  Model|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation<Model, $this, *>  $query
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Contracts\Database\Eloquent\Builder
     */
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        if ($binder = static::getBinder($field)) {
            return $binder->query($query, $value, $field ?? 'default');
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    /**
     * Get the binder for the model.
     *
     * A null field is the implicit route key, which this package exposes as the
     * `default` binding. Qualified columns (`posts.slug`) map to the binding
     * method of the same unqualified name.
     */
    protected static function getBinder(?string $field): ?Binder
    {
        return Binder::for(static::class, $field ?? 'default');
    }
}
