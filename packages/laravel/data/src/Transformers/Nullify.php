<?php

declare(strict_types=1);

namespace Honed\Data\Transformers;

use Attribute;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Nullify extends FormTransformer
{
    /**
     * The values to nullify.
     *
     * @var list<mixed>
     */
    public $values;

    public function __construct(mixed $values)
    {
        /** @var list<mixed> */
        $values = is_array($values) ? $values : func_get_args();

        $this->values = $values;
    }

    /**
     * Transform the value to a form property.
     */
    public function toFormData(
        DataProperty $property,
        mixed $value,
        TransformationContext $context
    ): mixed {

        if (in_array($value, $this->values, true)) {
            return null;
        }

        return $value;
    }
}
