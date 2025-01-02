<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Contracts;

use Honed\Core\Contracts\Makeable;

interface Formatter extends Makeable
{
    /**
     * Format the value.
     *
     * @template T of string|int|float|null
     *
     * @param  T  $value
     * @return T|mixed
     */
    public function format(mixed $value): mixed;
}
