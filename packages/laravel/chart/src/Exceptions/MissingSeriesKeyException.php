<?php

declare(strict_types=1);

namespace Honed\Chart\Exceptions;

class MissingSeriesKeyException extends \RuntimeException
{
    /**
     * Create a new missing series key exception.
     */
    public function __construct()
    {
        parent::__construct(
            \sprintf(
                'The series [%s] is missing the key to retrieve',
                static::class
            )
        );
    }

    /**
     * Throw a new missing series key exception.
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
