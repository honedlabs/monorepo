<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation;

use Attribute;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Support\Validation\ValidationPath;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Phone extends CustomValidationAttribute
{
    /**
     * The list of the countries to validate the phone number for.
     *
     * @var list<string>
     */
    protected $countries;

    /**
     * Create a new rule instance.
     * 
     * @param  string|list<string>  $countries
     */
    public function __construct(string|array $countries = [])
    {
        /** @var list<string> */
        $countries = is_array($countries) ? $countries : func_get_args();

        $this->countries = $countries;
    }
    /**
     * Get the validation rules for the attribute.
     *
     * @return array<object|string>|object|string
     */
    public function getRules(ValidationPath $path): array|object|string
    {
        $countries = implode(',', $this->countries);
        
        return "phone:{$countries}";
    }
}
