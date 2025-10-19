<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\UnsignedTinyInteger;
use Spatie\LaravelData\Data;

class UnsignedTinyIntegerData extends Data
{
    public function __construct(
        #[UnsignedTinyInteger]
        public int $test
    ) {}
}
