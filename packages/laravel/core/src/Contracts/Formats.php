<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface Formats extends Makeable
{
    /**
     * Format the value.
     *
     * @template TValue of string|int|float|null
     *
     * @param  TValue  $value
     * @return TValue|mixed
     */
    public function format($value);
}
