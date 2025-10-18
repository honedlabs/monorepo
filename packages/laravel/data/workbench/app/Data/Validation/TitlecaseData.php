<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Titlecase;
use Spatie\LaravelData\Data;

class TitlecaseData extends Data
{
    public function __construct(
        #[Titlecase]
        public string $test
    ) {}
}
