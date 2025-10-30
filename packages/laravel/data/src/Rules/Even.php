<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Honed\Data\Support\AbstractRule;

class Even extends AbstractRule
{
    /**
     * Check if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        $value = is_scalar($value) ? (int) $value : 0;

        return $value % 2 === 0;
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'even';
    }
}
