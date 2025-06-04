<?php

declare(strict_types=1);

namespace Honed\Binding\Concerns;

use Honed\Binding\Binder;

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
        if ($binder = Binder::for(static::class, $field)) {
            return $binder->resolve(static::class, $field, $value);
        }

        return parent::resolveRouteBinding($value, $field);
    }

    // /**
    //  * Get the value of the model's route key.
    //  *
    //  * @return mixed
    //  */
    // public function getRouteKey()
    // {
    //     return 
    // }
}
