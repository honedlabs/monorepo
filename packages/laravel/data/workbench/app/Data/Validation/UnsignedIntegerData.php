<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\UnsignedInteger;
use Spatie\LaravelData\Data;

class UnsignedIntegerData extends Data
{
    public function __construct(
        #[UnsignedInteger]
        public int $test
    ) {}
}
