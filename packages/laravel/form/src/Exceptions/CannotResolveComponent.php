<?php

declare(strict_types=1);

namespace Honed\Form\Exceptions;

use Exception;

class CannotResolveComponent extends Exception
{
    /**
     * Create a new exception.
     */
    final public function __construct(string $property)
    {
        parent::__construct(
            "Could not resolve a valid form component for [{$property}]."
        );
    }

    /**
     * Throw the exception.
     *
     * @throws self
     */
    public static function throw(string $property): never
    {
        throw new self($property);
    }
}
