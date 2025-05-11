<?php

declare(strict_types=1);

namespace Honed\Chart\Exceptions;

class MissingDataException extends \RuntimeException
{
    /**
     * Create a new missing data exception.
     */
    public function __construct()
    {
        parent::__construct(
            \sprintf(
                'The chart [%s] has not been supplied with any data.',
                static::class
            )
        );
    }

    /**
     * Throw a new missing data exception.
     *
     * @return never
     *
     * @throws static
     */
    public static function throw()
    {
        throw new self();
    }
}
