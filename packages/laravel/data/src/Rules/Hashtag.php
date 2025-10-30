<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Honed\Data\Support\AbstractRegexRule;

class Hashtag extends AbstractRegexRule
{
    /**
     * REGEX pattern of rule
     */
    protected function pattern(): string
    {
        return '/^#[^ !@#$%^&*(),.?":{}|<>]*$/';
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'hashtag';
    }
}
