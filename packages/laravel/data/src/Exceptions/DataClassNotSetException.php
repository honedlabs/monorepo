<?php

declare(strict_types=1);

namespace Honed\Data\Exceptions;

use Exception;

final class DataClassNotSetException extends Exception
{
    /**
     * Throw the exception.
     *
     * @throws self
     */
    public static function throw(): never
    {
        throw new self('Data class has not been set.');
    }
}
