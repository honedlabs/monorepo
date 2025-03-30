<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

use Honed\Action\Concerns\HasEncoder;

/**
 * @template TClass of \Honed\Core\Primitive
 */
trait HasRouteBinding
{
    use HasEncoder;
    
    /**
     * Get the primitive class for binding.
     *
     * @return class-string<TClass>
     */
    abstract public function primitive();
    
    /**
     * Get the value of the model's route key.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return static::encode(static::class);
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
            $class = static::decode($value);

            if (! \class_exists($class) || ! \is_subclass_of($class, $this->primitive())) {
                return null;
            }

            return $class::make();
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * Retrieve the child class for a bound value.
     * 
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
