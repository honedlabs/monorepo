<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Honed\Data\Support\AbstractRule;

class MaxWords extends AbstractRule
{
    public function __construct(
        protected int $maxWords,
    ) {}

    /**
     * Check if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        $value = is_scalar($value) ? (string) $value : '';

        return count(explode(' ', $value)) <= $this->maxWords;
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'max_words';
    }
}
