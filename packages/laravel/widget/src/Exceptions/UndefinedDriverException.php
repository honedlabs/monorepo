<?php

namespace Honed\Widget\Exceptions;

use InvalidArgumentException;

class UndefinedDriverException extends InvalidArgumentException
{
    /**
     * Throw an exception if the driver is not supported.
     * 
     * @param  string  $driver
     */
    public function __construct($driver)
    {
        parent::__construct("Driver [{$driver}] is not defined.");
    }

    public static function throw($driver)
    {
        throw new self($driver);
    }
}