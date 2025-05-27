<?php

namespace Honed\Core\Exceptions;

use RuntimeException;

class InvalidMethodException extends RuntimeException
{
    /**
     * Create a new invalid method exception.
     *
     * @param  string  $method
     */
    public function __construct($method)
    {
        parent::__construct(
            "The provided method [{$method}] is not a valid HTTP verb."
        );
    }

    /**
     * Throw a new invalid method exception.
     *
     * @param  string  $method
     * @return never
     *
     * @throws static
     */
    public static function throw($method)
    {
        throw new self($method);
    }
}
