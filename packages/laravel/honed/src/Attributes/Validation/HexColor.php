<?php

namespace Honed\Honed\Attributes\Validation;

use Attribute;
use Spatie\LaravelData\Support\Validation\References\ExternalReference;
use Spatie\LaravelData\Attributes\Validation\StringValidationAttribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class HexColor extends StringValidationAttribute
{
    public function __construct() {}

    /**
     * Get the keyword for the validation rule.
     */
    public static function keyword(): string
    {
        return 'hex_color';
    }

    /**
     * Get the parameters to pass to the validation rule.
     * 
     * @return []
     */
    public function parameters(): array
    {
        return [];
    }
}
