<?php

declare(strict_types=1);

namespace Honed\Data\Data;

use Exception;
use Honed\Data\DataPipes\PreparePropertiesDataPipe;
use Honed\Data\Support\DataContainer as SupportDataContainer;
use Spatie\LaravelData\Contracts\BaseData as BaseDataContract;
use Spatie\LaravelData\Contracts\BaseDataCollectable as BaseDataCollectableContract;
use Spatie\LaravelData\Contracts\ContextableData as ContextableDataContract;
use Spatie\LaravelData\Contracts\IncludeableData as IncludeableDataContract;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataPipeline;
use Spatie\LaravelData\Support\DataContainer;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Support\Transformation\TransformationContextFactory;

class FormData extends Data
{
    public static function pipeline(): DataPipeline
    {
        return parent::pipeline()
            ->firstThrough(PreparePropertiesDataPipe::class);
    }

    // /** @return array<string, mixed> */
    // public function transform(
    //     null|TransformationContextFactory|TransformationContext $transformationContext = null,
    // ): array {
    //     $transformationContext = match (true) {
    //         $transformationContext instanceof TransformationContext => $transformationContext,
    //         $transformationContext instanceof TransformationContextFactory => $transformationContext->get($this),
    //         $transformationContext === null => new TransformationContext(
    //             maxDepth: config('data.max_transformation_depth'),
    //             throwWhenMaxDepthReached: config('data.throw_when_max_transformation_depth_reached')
    //         )
    //     };

    //     $resolver = match (true) {
    //         $this instanceof self => SupportDataContainer::get()->fieldDataResolver(),
    //         $this instanceof BaseDataContract => DataContainer::get()->transformedDataResolver(),
    //         $this instanceof BaseDataCollectableContract => DataContainer::get()->transformedDataCollectableResolver(),
    //         default => throw new Exception('Cannot transform data object')
    //     };

    //     if ($this instanceof IncludeableDataContract && $this instanceof ContextableDataContract) {
    //         $transformationContext->mergePartialsFromDataContext($this);
    //     }

    //     return $resolver->execute($this, $transformationContext);
    // }
}
