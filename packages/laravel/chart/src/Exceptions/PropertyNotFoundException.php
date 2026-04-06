<?php

declare(strict_types=1);

namespace Honed\Chart\Exceptions;

use Exception;

class PropertyNotFoundException extends Exception
{
    /**
     * Throw the exception.
     */
    public static function throw(object $object, string $name): never
    {
        $class = get_class($object);

        throw new self(
            "Property {$class}::{$name} not found or not accessible."
        );
    }
}
