<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Lowercase;
use Spatie\LaravelData\Data;

class LowercaseData extends Data
{
    public function __construct(
        #[Lowercase]
        public string $test
    ) {}
}
