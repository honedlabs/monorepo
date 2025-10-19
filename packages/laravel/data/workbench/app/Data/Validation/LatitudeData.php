<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Latitude;
use Spatie\LaravelData\Data;

class LatitudeData extends Data
{
    public function __construct(
        #[Latitude]
        public string $test
    ) {}
}
