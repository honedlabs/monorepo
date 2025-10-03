<?php

declare(strict_types=1);

namespace Honed\Infolist\Contracts;

/**
 * @template TValue
 * @template TReturn
 */
interface Formatter
{
    /**
     * @param TValue $value
     * @return TReturn
     */
    public function format(mixed $value): mixed;
}