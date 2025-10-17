<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation;

use Attribute;
use Intervention\Validation\Rules\Camelcase as CamelcaseRule;
use Spatie\LaravelData\Support\Validation\ValidationPath;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Camelcase extends CustomValidationAttribute
{
    public function __construct() {}

    /**
     * Get the validation rules for the attribute.
     * 
     * @return array<object|string>|object|string
     */
    public function getRules(ValidationPath $path): array|object|string
    {
        return [new CamelcaseRule()];
    }
}