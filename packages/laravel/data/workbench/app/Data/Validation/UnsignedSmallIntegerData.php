<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\UnsignedSmallInteger;
use Spatie\LaravelData\Data;

class UnsignedSmallIntegerData extends Data
{
    public function __construct(
        #[UnsignedSmallInteger]
        public int $test
    ) {}
}
