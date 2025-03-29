<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

/**
 * @template TClass of \Honed\Core\Primitive
 */
trait HasRouteBindings
{
    /**
     * Get the class to be used for route binding.
     *
     * @return string
     */
    abstract public function bindingClass();
    
    /**
     * Get the value of the model's route key.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return ($this->bindingClass())::encode(static::class);
    }

    /**
     * Retrieve the class for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return TClass|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $class = ($this->bindingClass())::decode($value);

            if (! \class_exists($class) || ! \is_subclass_of($class, $this->bindingClass())) {
                return null;
            }

            return $class::make();
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * @param  string  $childType
     * @param  string  $value
     * @param  string|null  $field
     * @return TClass|null
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return $this->resolveRouteBinding($value, $field);
    }
}
