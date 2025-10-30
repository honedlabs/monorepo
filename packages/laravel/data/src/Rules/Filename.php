<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Honed\Data\Support\AbstractRule;

class Filename extends AbstractRule
{
    /**
     * @param  list<string>  $extensions
     */
    public function __construct(
        protected array $extensions = [],
    ) {}

    /**
     * Check if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        return match (true) {
            ! is_string($value) => false,
            str_contains($value, '/') || str_contains($value, '\\') => false,
            empty($this->extensions) => true,
            default => in_array(mb_strtolower(pathinfo($value, PATHINFO_EXTENSION)), $this->extensions, true),
        };
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'filename';
    }
}
