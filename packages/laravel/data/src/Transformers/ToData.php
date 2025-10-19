<?php

declare(strict_types=1);

namespace Honed\Data\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

/**
 * @template TData of \Spatie\LaravelData\Contracts\BaseData
 */
class ToData implements Transformer
{
    /**
     * @param  class-string<TData>  $data
     */
    public function __construct(
        public string $data
    ) {}

    /**
     * Transform the value to a data object.
     */
    public function transform(
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
