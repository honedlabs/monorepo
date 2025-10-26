<?php

declare(strict_types=1);

namespace Honed\Data\Exceptions;

use Exception;

class DataClassNotSetException extends Exception
{
    /**
     * Create a new exception.
     *
     * @param class-string|object $class
     */
    final public function __construct(string|object $class)
    {
        $className = is_string($class) ? $class : get_class($class);

        parent::__construct(
            sprintf('Data class has not been set for [%s].', $className)
        );
    }
    /**
     * Throw the exception.
     *
     * @param class-string|object $class
     * 
     * @throws self
     */
    public static function throw(string|object $class): never
    {
        throw new self($class);
    }
}
