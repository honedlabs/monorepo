<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Kebabcase;
use Spatie\LaravelData\Data;

class KebabcaseData extends Data
{
    public function __construct(
        #[Kebabcase]
        public string $test
    ) {}
}
