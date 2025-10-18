<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Snakecase;
use Spatie\LaravelData\Data;

class SnakecaseData extends Data
{
    public function __construct(
        #[Snakecase]
        public string $test
    ) {}
}
