<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\HslColor;
use Spatie\LaravelData\Data;

class HslColorData extends Data
{
    public function __construct(
        #[HslColor]
        public string $test
    ) {}
}
