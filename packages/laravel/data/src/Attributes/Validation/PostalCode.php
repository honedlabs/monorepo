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
     * @param  list<string>  $countryCodes
     */
    public function __construct(
        protected array $countryCodes = []
    ) {}

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
