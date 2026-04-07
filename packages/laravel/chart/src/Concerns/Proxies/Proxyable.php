<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Proxies;

use ReflectionProperty;

trait Proxyable
{
    /**
     * Get a property of the object.
     */
    abstract public function __get(string $name): mixed;

    /**
     * Perform the default get operation for a property.
     */
    protected function defaultGet(string $name): mixed
    {
        if (property_exists($this, $name)) {
            $ref = new ReflectionProperty($this, $name);

            if ($ref->isPublic()) {
                return $this->{$name};
            }

            trigger_error(
                sprintf('Cannot access non-public property %s::$%s', static::class, $name),
                E_USER_NOTICE
            );

            return null;
        }

        trigger_error(
            sprintf('Undefined property: %s::$%s', static::class, $name),
            E_USER_NOTICE
        );

        return null;
    }
}
