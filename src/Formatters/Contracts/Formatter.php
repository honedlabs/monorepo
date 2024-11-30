<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Contracts;

use Honed\Core\Contracts\Makeable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Tappable;

interface Formatter extends Makeable
{
    /**
     * Format the value.
     * 
     * @template T
     * @param T $value
     * @return T|mixed
     */
    public function format(mixed $value): mixed;
}
