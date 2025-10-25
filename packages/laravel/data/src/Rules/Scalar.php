<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Intervention\Validation\AbstractRule;

class Scalar extends AbstractRule
{
    /**
     * Check if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        if (is_array($value)) {
            foreach ($value as $item) {
                if (! is_scalar($item)) {
                    return false;
                }
            }

            return true;
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
