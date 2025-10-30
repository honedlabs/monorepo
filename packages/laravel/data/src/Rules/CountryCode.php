<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Illuminate\Support\Arr;
use Honed\Data\Support\AbstractRule;
use League\ISO3166\ISO3166;

class CountryCode extends AbstractRule
{
    /**
     * Check if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        return in_array($value, $this->getCountryCodes());
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'country_code';
    }

    /**
     * Get the list of country codes.
     *
     * @return list<string>
     */
    protected function getCountryCodes(): array
    {
        /** @var list<string> */
        return Arr::pluck((new ISO3166())->all(), ISO3166::KEY_ALPHA2);
    }
}
