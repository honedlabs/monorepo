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
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($binder = static::getBinder($field ?? 'default')) {
            return $binder->resolve(static::class, $field ?? 'default', $value);
        }

        return parent::resolveRouteBinding($value, $field);
    }

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
     * @param  string  $field
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function bindBy($field, $value = null)
    {
        return static::binder($field)
            ->resolve(static::class, $value, $field);
    }

    /**
     * Get models using the specified binding.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Collection<int, $this>
     */
    public static function bindOn($field, $value = null)
    {
        return static::binder($field)
            ->query(static::class, $value, $field)
            ->get();
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
