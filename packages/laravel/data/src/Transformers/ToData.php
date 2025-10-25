<?php

declare(strict_types=1);

namespace Honed\Data\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;

/**
 * @template TData of \Spatie\LaravelData\Contracts\BaseData
 */
class ToData extends FormTransformer
{
    /**
     * @param  class-string<TData>  $data
     */
    public function __construct(
        public string $data
    ) {}

    /**
     * Transform the value to field data.
     */
    public function toFormData(
        DataProperty $property,
        mixed $value,
        TransformationContext $context
    ): mixed {

        if ($property->type->acceptsType('array')) {
            return ($this->data)::collect((array) $value, 'array');
        }

        return ($this->data)::from($value);
    }
}
