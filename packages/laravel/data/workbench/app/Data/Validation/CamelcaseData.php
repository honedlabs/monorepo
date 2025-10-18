<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\CamelCase;
use Spatie\LaravelData\Data;

class CamelcaseData extends Data
{
    public function __construct(
        #[CamelCase]
        public string $test
    ) {}
}
