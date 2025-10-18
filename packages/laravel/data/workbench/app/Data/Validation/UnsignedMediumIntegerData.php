<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\UnsignedMediumInteger;
use Spatie\LaravelData\Data;

class UnsignedMediumIntegerData extends Data
{
    public function __construct(
        #[UnsignedMediumInteger]
        public int $test
    ) {}
}
