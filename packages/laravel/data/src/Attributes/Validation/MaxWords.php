<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation;

use Attribute;
use Honed\Data\Rules\MaxWords as MaxWordsRule;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Support\Validation\ValidationPath;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class MaxWords extends CustomValidationAttribute
{
    public function __construct(
        protected int $maxWords,
    ) {}

    /**
     * Get the validation rules for the attribute.
     *
     * @return array<object|string>|object|string
     */
    public function getRules(ValidationPath $path): array|object|string
    {
        return [new MaxWordsRule($this->maxWords)];
    }
}
