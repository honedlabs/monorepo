<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Intervention\Validation\AbstractRegexRule;

class Whitespace extends AbstractRegexRule
{
    /**
     * REGEX pattern of rule
     */
    protected function pattern(): string
    {
        return '/^[^\s]*$/';
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'whitespace';
    }
}
