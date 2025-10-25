<?php

declare(strict_types=1);

namespace Honed\Data\Transformers;

use Honed\Data\Support\Transformation\FormTransformationContext;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

abstract class FormTransformer implements Transformer
{
    /**
     * Transform the value to a form property.
     */
    abstract public function toFormData(
        DataProperty $property,
        mixed $value,
        TransformationContext $context
    ): mixed;

    /**
     * Transform the value, only if form transformation context is provided.
     */
    public function transform(
        DataProperty $property,
        mixed $value,
        TransformationContext $context
    ): mixed {

        if ($context instanceof FormTransformationContext) {
            return $this->toFormData($property, $value, $context);
        }

        return $value;
    }
}
