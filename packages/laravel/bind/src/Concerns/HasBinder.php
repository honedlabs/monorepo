<?php

declare(strict_types=1);

namespace Honed\Bind\Concerns;

use Honed\Bind\Attributes\UseBinder;
use Honed\Bind\Binder;
use ReflectionClass;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasBinder
{
    /**
     * The binder for the model.
     *
     * @var class-string<Binder>|null
     */
    protected $binder;

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($binder = $this->binder($field)) {
            return $binder->resolve(static::class, $field, $value);
        }

        if ($binder = Binder::for(static::class, $field)) {
            return $binder->resolve(static::class, $field, $value);
        }

        return parent::resolveRouteBinding($value, $field);
    }

    public function binder($field)
    {
        return match (true) {
            isset($this->binder) => new $this->binder(),
            $binder = static::getUseBinderAttribute() => $binder,
            $binder = Binder::for(static::class, $field) => $binder,
            default => null,
        };
    }

    /**
     * Get the binder from the UseBinder class attribute.
     *
     * @return class-string<Binder>|null
     */
    public static function getUseBinderAttribute()
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(UseBinder::class);

        if ($attributes !== []) {
            $useBinder = $attributes[0]->newInstance();

            $binder = $useBinder->bindingClass;

            $binder::guessModelNamesUsing(fn () => static::class);

            return $binder;
        }

        return null;
    }
}
