<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\SignedTinyInteger;
use Spatie\LaravelData\Data;

class SignedTinyIntegerData extends Data
{
    public function __construct(
        #[SignedTinyInteger]
        public int $test
    ) {}
}
