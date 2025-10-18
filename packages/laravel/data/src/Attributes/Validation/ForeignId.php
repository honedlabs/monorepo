<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation;

use Attribute;
use Honed\Data\Rules\RecordsExist;
use Honed\Data\Rules\Scalar;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Support\Validation\ValidationPath;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class ForeignId extends CustomValidationAttribute
{
    /**
     * @param class-string<TModel|QueryRule<TModel, TBuilder>>
     */
    public function __construct(
        protected string $query,
        protected ?string $column = null
    ) {}

    /**
     * Get the validation rules for the attribute.
     *
     * @return array<object|string>|object|string
     */
    public function getRules(ValidationPath $path): array|object|string
    {
        return [new Scalar(), new RecordsExist($this->query, $this->column)];
    }
}
