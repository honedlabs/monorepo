<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Illuminate\Support\Arr;
use Intervention\Validation\AbstractRule;

class Scalar extends AbstractRule
{
    /**
     * Checks if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        if (is_array($value)) {
            return Arr::every(
                $value, 
                static fn (mixed $value): bool => is_scalar($value)
            );
        }

        return is_scalar($value);
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'scalar';
    }
}