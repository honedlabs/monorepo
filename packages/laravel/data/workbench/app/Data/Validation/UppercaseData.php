<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Uppercase;
use Spatie\LaravelData\Data;

class UppercaseData extends Data
{
    public function __construct(
        #[Uppercase]
        public string $test
    ) {}
}
