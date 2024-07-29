<?php

namespace Conquest\Core\Exceptions;

use Exception;

/**
 * Missing required attribute exception.
 */
class MissingRequiredAttributeException extends Exception
{
    public function __construct(string $attrbiute, mixed $class = null)
    {
        if (is_null($class)) {
            parent::__construct('Class is missing required attribute: '.$attrbiute);

            return;
        }
        parent::__construct('Class is missing required attribute '.$attrbiute.' for '.get_class($class));
    }
}
