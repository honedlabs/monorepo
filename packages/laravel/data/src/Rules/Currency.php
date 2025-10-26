<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use League\ISO3166\ISO3166;
use Intervention\Validation\AbstractRule;

class Currency extends AbstractRule
{
    /**
     * Check if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        return in_array($value, $this->getCurrencies());
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'currency';
    }

    /**
     * Get the list of country codes.
     *
     * @return list<string>
     */
    protected function getCurrencies(): array
    {
        /** @var list<string> */
        return array_unique((array) data_get((new ISO3166())->all(), '*.currency.*'));
    }
}
