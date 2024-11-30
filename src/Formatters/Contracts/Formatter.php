<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Contracts;

interface Formatter
{
    public function format(mixed $value): string;
}
