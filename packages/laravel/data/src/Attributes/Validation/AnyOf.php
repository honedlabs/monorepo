<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation;

use Attribute;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Support\Validation\ValidationPath;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class AnyOf extends CustomValidationAttribute
{
    /**
     * The rules to check against.
     *
     * @var list<string|ValidationRule>
     */
    protected array $rules = [];

    /**
     * Create a new rule attribute.
     *
     * @param  string|ValidationRule|list<string|ValidationRule>  $rules
     */
    public function __construct(string|ValidationRule|array $rules)
    {
        /** @var list<string|ValidationRule> */
        $rules = is_array($rules) ? $rules : func_get_args();

        $this->rules = $rules;
    }

    /**
     * Get the validation rules for the attribute.
     *
     * @return array<object|string>|object|string
     */
    public function getRules(ValidationPath $path): array|object|string
    {
        return Rule::anyOf($this->rules);
    }
}
