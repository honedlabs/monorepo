<?php

declare(strict_types=1);

namespace Honed\Form\Exceptions;

use Exception;

class RouteNotSetException extends Exception
{
    /**
     * Create a new exception.
     */
    final public function __construct()
    {
        parent::__construct(
            'The lookup component requires a route to be set.'
        );
    }

    /**
     * Throw the exception.
     *
     * @throws self
     */
    public static function throw(): never
    {
        throw new self();
    }
}
