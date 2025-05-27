<?php

namespace Honed\Core\Exceptions;

use RuntimeException;

class ResourceNotSetException extends RuntimeException
{
    /**
     * Create a new resource not set exception.
     * 
     * @param  class-string  $class
     */
    public function __construct($class)
    {
        parent::__construct(
            "Resource has not been set for [{$class}]."
        );
    }

    /**
     * Throw a new resource not set exception.
     *
     * @param  class-string  $class
     * @return never
     *
     * @throws static
     */
    public static function throw($class)
    {
        throw new self($class);
    }
}