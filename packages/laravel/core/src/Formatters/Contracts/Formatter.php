<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Contracts;

use Honed\Core\Contracts\Makeable;

interface Formatter extends Makeable
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
