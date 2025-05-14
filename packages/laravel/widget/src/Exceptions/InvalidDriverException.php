<?php

namespace Honed\Widget\Exceptions;

use InvalidArgumentException;

class InvalidDriverException extends InvalidArgumentException
{
    /**
     * Throw an exception if the driver is not supported.
     * 
     * @param  string  $driver
     */
    public function __construct($driver)
    {
        parent::__construct("Driver [{$driver}] is not supported.");
    }

    public static function throw($driver)
    {
        
    }
}