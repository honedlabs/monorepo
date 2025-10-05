<?php

declare(strict_types=1);

namespace Honed\Infolist\Contracts;

/**
 * @template-contravariant TValue
 *
 * @template-covariant TReturn
 */
interface Formatter
{
    /**
     * Format the given value.
     *
     * @param  TValue  $value
     * @return TReturn
     */
    public function format(mixed $value): mixed;
}
