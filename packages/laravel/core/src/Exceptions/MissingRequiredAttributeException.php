<?php

namespace Honed\Core\Exceptions;

use Exception;

/**
 * Missing required attribute exception.
 */
class MissingRequiredAttributeException extends Exception
{
    public function __construct(string $attribute, ?string $class = null)
    {
        $message = \is_null($class)
            ? sprintf('Class is missing required attribute [%s]', $attribute)
            : sprintf('Class [%s] is missing required attribute [%s]', $class, $attribute);

        parent::__construct($message);
    }
}
