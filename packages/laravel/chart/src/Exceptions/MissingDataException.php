<?php

declare(strict_types=1);

namespace Honed\Chart\Exceptions;

use Exception;

class MissingDataException extends Exception
{
    /**
     * Throw the exception.
     */
    public static function throw(): never
    {
        throw new self(
            'No data has been set when attempting to resolve it. Please supply data directly via the ->data(...) method or a source via the ->from(...) method.'
        );
    }
}
