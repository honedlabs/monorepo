<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Honed\Data\Support\AbstractRule;
use Illuminate\Support\Arr;
use League\ISO3166\ISO3166;

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
        return array_values(
            array_unique(
                Arr::flatten(
                    Arr::pluck((new ISO3166())->all(), 'currency')
                )
            )
        );
    }
}
