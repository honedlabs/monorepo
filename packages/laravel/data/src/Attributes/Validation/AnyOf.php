<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation;

use Attribute;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Support\Validation\ValidationPath;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class AnyOf extends CustomValidationAttribute
{
    /**
     * The rules to check against.
     *
     * @var list<string|class-string<\Illuminate\Contracts\Validation\ValidationRule>>
     */
    protected array $rules = [];

    /**
     * Create a new rule attribute.
     *
     * @param  string|class-string<\Illuminate\Contracts\Validation\ValidationRule>|list<class-string<\Illuminate\Contracts\Validation\ValidationRule>>  $rules
     */
    public function __construct(string|array $rules)
    {
        /** @var list<string|class-string<\Illuminate\Contracts\Validation\ValidationRule>> */
        $rules = is_string($rules) ? [$rules] : $rules;

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
