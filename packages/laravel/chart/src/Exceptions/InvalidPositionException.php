<?php

declare(strict_types=1);

namespace Honed\Chart\Exceptions;

class InvalidPositionException extends \RuntimeException
{
    /**
     * Create a new invalid position exception.
     *
     * @param  string  $type
     * @param  string  $direction
     */
    public function __construct($type, $direction)
    {
        parent::__construct(
            \sprintf(
                'The provided [%s] position [%s] is invalid.',
                $direction,
                $type
            )
        );
    }

    /**
     * Throw a new invalid position exception.
     *
     * @param  string  $type
     * @return never
     *
     * @throws static
     */
    public static function throw($type, $direction = 'horizontal')
    {
        throw new self($type, $direction);
    }
}
