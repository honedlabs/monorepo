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
     * @var list<class-string<\Illuminate\Validation\Rule>>
     */
    protected array $rules = [];

    /**
     * Create a new rule attribute.
     * 
     * @param  class-string<\Illuminate\Validation\Rule>|list<class-string<\Illuminate\Validation\Rule>>  $rules
     */
    public function __construct(string|array $rules)
    {
        $this->rules = is_array($rules) ? $rules : func_get_args();
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
