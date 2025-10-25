<?php

declare(strict_types=1);

namespace Honed\Data\Concerns;

use Honed\Data\DataPipes\PreparePropertiesDataPipe;
use Honed\Data\Support\Transformation\FormTransformationContext;
use Spatie\LaravelData\DataPipeline;

/**
 * @phpstan-require-extends \Spatie\LaravelData\Data
 */
trait FormsData
{
    /**
     * Define the pipeline for the data.
     */
    public static function pipeline(): DataPipeline
    {
        return parent::pipeline()
            ->firstThrough(PreparePropertiesDataPipe::class);
    }

    /**
     * Transform the data to form data.
     *
     * @return array<string, mixed>
     */
    public function toForm(): array
    {
        return $this->transform(
            FormTransformationContext::make()
        );
    }
}
