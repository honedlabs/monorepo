<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\SignedSmallInteger;
use Spatie\LaravelData\Data;

class SignedSmallIntegerData extends Data
{
    public function __construct(
        #[SignedSmallInteger]
        public int $test
    ) {}
}
