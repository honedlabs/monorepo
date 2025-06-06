<?php

declare(strict_types=1);

namespace Honed\Bind\Concerns;

use Honed\Bind\Binder;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasBinder
{
    /**
     * Get the binder for the model.
     *
     * @param  string|null  $field
     * @return Binder|null
     */
    public static function binder($field)
    {
        return static::getBinder($field);
    }

    /**
     * Get a model using the specified binding.
     *
     * @param  string|null  $field
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function firstBound($field = null, $value = null)
    {
        $field ??= 'default';

        return static::binder($field)
            ?->resolve(static::query(), $value, $field);
    }

    /**
     * Scope the query using the specified binding.
     *
     * @param  string|null  $field
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder<static>
     */
    public static function whereBound($field = null, $value = null)
    {
        $field ??= 'default';

        $query = static::query();

        return static::binder($field)?->query($query, $value, $field) ?? $query;
    }

    /**
     * Get models using the specified binding.
     *
     * @param  string|null  $field
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Collection<int, $this>
     */
    public static function getBound($field = null, $value = null)
    {
        return static::whereBound($field, $value)
            ->get();
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
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
     *
     * @param  string|null  $field
     * @return Binder|null
     */
    protected static function getBinder($field)
    {
        return Binder::for(static::class, $field);
    }
}
