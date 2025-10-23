<?php

declare(strict_types=1);

namespace Honed\Data\Resolvers;

use Spatie\LaravelData\Resolvers\TransformedDataResolver;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\ArrayableTransformer;
use Spatie\LaravelData\Transformers\Transformer;

class FormDataResolver extends TransformedDataResolver
{
    protected function resolveTransformerForValue(
        DataProperty $property,
        mixed $value,
        TransformationContext $context,
    ): ?Transformer {
        if (! $context->transformValues) {
            return null;
        }

        $field = $property->attributes->first(Field::class);

        $transformer = match (true) {
            $field === null => $property->transformer,
            default => $field->transformer
        };

        if ($transformer === null && $context->transformers) {
            $transformer = $context->transformers->findTransformerForValue($value);
        }

        if ($transformer === null) {
            $transformer = $this->dataConfig->transformers->findTransformerForValue($value);
        }

        $shouldUseDefaultDataTransformer = $transformer instanceof ArrayableTransformer
            && $property->type->kind->isDataRelated();

        if ($shouldUseDefaultDataTransformer) {
            return null;
        }

        return $transformer;
    }
}
