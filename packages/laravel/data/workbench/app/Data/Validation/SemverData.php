<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Semver;
use Spatie\LaravelData\Data;

class SemverData extends Data
{
    public function __construct(
        #[Semver]
        public string $test
    ) {}
}
