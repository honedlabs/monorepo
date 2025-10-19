<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\HexColor;
use Spatie\LaravelData\Data;

class HexColorData extends Data
{
    public function __construct(
        #[HexColor]
        public string $test
    ) {}
}
