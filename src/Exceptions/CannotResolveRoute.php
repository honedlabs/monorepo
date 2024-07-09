<?php

namespace Conquest\Core\Exceptions;

use Exception;

class CannotResolveRoute extends Exception
{
    public function __construct(mixed $class)
    {
        parent::__construct('Route not defined for '.get_class($class));
    }
}
