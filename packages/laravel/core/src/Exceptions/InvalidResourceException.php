<?php

declare(strict_types=1);

namespace Honed\Core\Exceptions;

use RuntimeException;

use function get_class;
use function is_object;

class InvalidResourceException extends RuntimeException
{
    /**
     * Create a new invalid resource exception.
     *
     * @param  object|class-string  $resource
     */
    public function __construct($resource)
    {
        $class = is_object($resource) ? get_class($resource) : $resource;

        parent::__construct(
            "No builder instance can be created for the given resource [{$class}]."
        );
    }

    /**
     * Throw a new invalid resource exception.
     *
     * @param  object|class-string  $resource
     * @return never
     *
     * @throws static
     */
    public static function throw($resource)
    {
        throw new self($resource);
    }
}
