<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation;

use Attribute;
use Honed\Data\Rules\Youtube as YoutubeRule;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Support\Validation\ValidationPath;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Youtube extends CustomValidationAttribute
{
    /**
     * Get the validation rules for the attribute.
     *
     * @return array<object|string>|object|string
     */
    public function getRules(ValidationPath $path): array|object|string
    {
        return [new YoutubeRule()];
    }
}
