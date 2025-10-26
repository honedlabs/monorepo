<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Scalar;
use Spatie\LaravelData\Data;

class ScalarData extends Data
{
    public function __construct(
        #[Scalar]
        public mixed $test
    ) {}
}
