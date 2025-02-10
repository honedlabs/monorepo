<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Table;

trait HasTableBindings
{
    /**
     * @return string
     */
    public function getRouteKey()
    {
        return $this->encode(static::class);
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * @return \Honed\Table\Table|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $class = Table::decode($value);

            if (! \class_exists($class) || ! \is_subclass_of($class, Table::class)) {
                return null;
            }

            return $class::make();
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * @return \Honed\Table\Table|null
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return $this->resolveRouteBinding($value, $field);
    }
}
