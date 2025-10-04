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
     * @param  TValue|null  $value
     * @return TReturn|null
     */
    public function format(mixed $value): mixed;
}
