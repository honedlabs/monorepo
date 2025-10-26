<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation;

use Attribute;
use Honed\Data\Rules\Authorized as AuthorizedRule;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Support\Validation\ValidationPath;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Authorized extends CustomValidationAttribute
{
    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $className
     */
    public function __construct(
        protected string $ability,
        protected string $className,
        protected ?string $column = null,
        protected ?string $guard = null,
    ) {}

    /**
     * Get the validation rules for the attribute.
     *
     * @return array<object|string>|object|string
     */
    public function getRules(ValidationPath $path): array|object|string
    {
        return [new AuthorizedRule(
            $this->ability,
            $this->className,
            $this->column,
            $this->guard,
        )];
    }
}
