<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\HsvColor;
use Spatie\LaravelData\Data;

class HsvColorData extends Data
{
    public function __construct(
        #[HsvColor]
        public string $test
    ) {}
}
