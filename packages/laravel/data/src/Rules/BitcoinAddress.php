<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Intervention\Validation\AbstractRegexRule;

class BitcoinAddress extends AbstractRegexRule
{
    /**
     * REGEX pattern of rule
     */
    protected function pattern(): string
    {
        return '/^(?:bc1|[13])[a-zA-HJ-NP-Z0-9]{25,39}$/';
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'bitcoin_address';
    }
}
