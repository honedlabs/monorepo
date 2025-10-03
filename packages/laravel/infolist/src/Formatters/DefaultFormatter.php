<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Contracts\Formatter;

/**
 * @implements Formatter<mixed, mixed>
 */
class DefaultFormatter implements Formatter
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function format(mixed $value): mixed
    {
        return $value;
    }
}