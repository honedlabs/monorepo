<?php

declare(strict_types=1);

namespace Honed\Data\Support\Transformation;

use Spatie\LaravelData\Support\Transformation\TransformationContext;

final class FormTransformationContext extends TransformationContext
{
    /**
     * Create a new form transformation context.
     */
    public static function make(): static
    {
        /** @var int */
        $depth = config('data.max_transformation_depth');

        $maxDepth = (bool) config('data.throw_when_max_transformation_depth_reached');

        return new self(maxDepth: $depth, throwWhenMaxDepthReached: $maxDepth);
    }
}
