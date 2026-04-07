<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Dimension: string
{
    case X = 'x';
    case Y = 'y';

    /**
     * Determine if the dimension is the same as the given value.
     */
    public function is(mixed $value): bool
    {
        return $this === $value || $this->value === $value;
    }
}
