<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Illuminate\Support\Arr;
use Intervention\Validation\AbstractRule;
use League\ISO3166\ISO3166;

class Country extends AbstractRule
{
    /**
     * Check if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        return in_array($value, $this->getCountryNames());
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'country';
    }

    /**
     * Get the list of country codes.
     *
     * @return list<string>
     */
    protected function getCountryNames(): array
    {
        /** @var list<string> */
        return Arr::pluck((new ISO3166())->all(), ISO3166::KEY_NAME);
    }
}
