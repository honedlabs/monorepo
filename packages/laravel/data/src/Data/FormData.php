<?php

declare(strict_types=1);

namespace Honed\Data\Data;

use Honed\Data\DataPipes\PreparePropertiesDataPipe;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataPipeline;

class FormData extends Data
{
    public static function pipeline(): DataPipeline
    {
        return parent::pipeline()->firstThrough(PreparePropertiesDataPipe::class);
    }
}
