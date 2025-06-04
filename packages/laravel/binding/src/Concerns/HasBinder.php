<?php

declare(strict_types=1);

namespace Honed\Binding\Concerns;

use Honed\Binding\Attributes\UseBinder;
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

    /**
     * Get the binder from the UseBinder class attribute.
     * 
     * @return class-string<\Honed\Binding\Binder>|null
     */
    public static function getUseBinderAttribute()
    {
        $attributes = (new \ReflectionClass(static::class))
            ->getAttributes(UseBinder::class);

        if ($attributes !== []) {
            $useBinder = $attributes[0]->newInstance();

            $binder = $useBinder->bindingClass;

            $binder::guessModelNamesUsing(fn () => static::class);

            return $binder;
        }

        return null;
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
