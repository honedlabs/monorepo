<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Longitude;
use Spatie\LaravelData\Data;

class LongitudeData extends Data
{
    public function __construct(
        #[Longitude]
        public float $test
    ) {}
}
