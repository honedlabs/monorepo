<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Luhn;
use Spatie\LaravelData\Data;

class LuhnData extends Data
{
    public function __construct(
        #[Luhn]
        public string $test
    ) {}
}
