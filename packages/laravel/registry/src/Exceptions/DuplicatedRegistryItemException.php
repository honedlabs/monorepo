<?php

namespace Honed\Registry\Exceptions;

use RuntimeException;

class DuplicatedRegistryItemException extends RuntimeException
{
    /**
     * Create a new duplicated registry item exception.
     * 
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct(
            "The registry item [{$name}] is already registered."
        );
    }

    /**
     * Throw a new duplicated registry item exception.
     *
     * @param string $name
     * @return never
     * 
     * @throws static
     */
    public static function throw($name)
    {
        throw new self($name);
    }
}