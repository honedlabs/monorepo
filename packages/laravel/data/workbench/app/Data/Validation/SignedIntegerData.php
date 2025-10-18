<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\SignedInteger;
use Spatie\LaravelData\Data;

class SignedIntegerData extends Data
{
    public function __construct(
        #[SignedInteger]
        public int $test
    ) {}
}
