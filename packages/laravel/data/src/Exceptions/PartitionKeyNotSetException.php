<?php

declare(strict_types=1);

namespace Honed\Data\Exceptions;

use Exception;

final class PartitionKeyNotSetException extends Exception
{
    /**
     * Create a new exception.
     * 
     * @param class-string|object $class
     */
    public function __construct(string $key, string|object $class)
    {
        $className = is_string($class) ? $class : get_class($class);

        parent::__construct(
            sprintf('Partition key [%s] does not exist for data class [%s].', $key, $className)
        );
    }
    /**
     * Throw the exception.
     *
     * @param class-string|object $class
     * @throws self
     */
    public static function throw(string $key, string|object $class): never
    {
        throw new self($key, $class);
    }
}
