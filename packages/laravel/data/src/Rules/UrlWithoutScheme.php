<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\Rule;
use Intervention\Validation\AbstractRule;

class UrlWithoutScheme extends AbstractRule
{
    /**
     * Check if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        $value = is_scalar($value) ? (string) $value : '';

        if (! parse_url($value, PHP_URL_SCHEME)) {
            $value = "https://{$value}";
        }

        return ! app(Factory::class)->make(compact('value'), ['value' => 'url'])->fails();
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'url';
    }
}
