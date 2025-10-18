<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\SignedMediumInteger;
use Spatie\LaravelData\Data;

class SignedMediumIntegerData extends Data
{
    public function __construct(
        #[SignedMediumInteger]
        public int $test
    ) {}
}
