<?php

declare(strict_types=1);

namespace Honed\Chart\Exceptions;

class InvalidAxisException extends \RuntimeException
{
    /**
     * Create a new invalid action exception.
     *
     * @param  string  $type
     */
    public function __construct($type)
    {
        parent::__construct(
            \sprintf(
                'The provided axis type [%s] is invalid.',
                $type
            )
        );
    }

    /**
     * Throw a new invalid axis exception.
     *
     * @param  string  $type
     * @return never
     *
     * @throws static
     */
    public static function throw($type)
    {
        throw new self($type);
    }
}
