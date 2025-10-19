<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation;

use Attribute;
use Intervention\Validation\Rules\Postalcode as PostalcodeRule;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Support\Validation\ValidationPath;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class PostalCode extends CustomValidationAttribute
{
    /**
     * List of country codes.
     *
     * @var list<string>
     */
    public array $countryCodes;

    public function __construct(string ...$countryCodes)
    {
        // @phpstan-ignore-next-line parameter.type
        $this->countryCodes = $countryCodes;
    }

    /**
     * Get the validation rules for the attribute.
     *
     * @return list<object|string>|object|string
     */
    public function getRules(ValidationPath $path): array|object|string
    {
        return [new PostalcodeRule($this->countryCodes)];
    }
}
