<?php

namespace Honed\Binding\Concerns;

use Honed\Binding\Attributes\UseBinding;

/**
 * @template TBinding of \Illuminate\Database\Eloquent\Factories\Binding
 * 
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasBindings
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
        if ($binder = static::bindings($value)) {
            return $this->resolveHonedRouteBinding($binder, $value, $field);
        }

        return parent::resolveRouteBinding($value, $field);
    }
    

    public function resolveHonedRouteBinding($binder, $value, $field)
    {
        return $binder->resolve($value, $field);
    }

    /**
     * Get a new binding instance for the model.
     *
     * @param  (callable(array<string, mixed>, static|null): array<string, mixed>)|array<string, mixed>|int|null  $count
     * @param  (callable(array<string, mixed>, static|null): array<string, mixed>)|array<string, mixed>  $state
     * @return TBinding
     */
    public static function bindings($count = null, $state = [])
    {
        $binding = static::newBinding() ?? Binding::bindingForModel(static::class);

        return $binding
            ->count(is_numeric($count) ? $count : null)
            ->state(is_callable($count) || is_array($count) ? $count : $state);
    }

    /**
     * Create a new binding instance for the model.
     *
     * @return TBinding|null
     */
    protected static function newBinding()
    {
        if (isset(static::$binding)) {
            return static::$binding::new();
        }

        return static::getUseBindingAttribute() ?? null;
    }

    /**
     * Get the binding from the UseBinding class attribute.
     *
     * @return TBinding|null
     */
    protected static function getUseBindingAttribute()
    {
        $attributes = (new \ReflectionClass(static::class))
            ->getAttributes(UseBinding::class);

        if ($attributes !== []) {
            $useBinding = $attributes[0]->newInstance();

            $binding = $useBinding->bindingClass::new();

            $binding->guessModelNamesUsing(fn () => static::class);

            return $binding;
        }
    }
}
