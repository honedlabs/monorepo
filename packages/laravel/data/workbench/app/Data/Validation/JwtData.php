<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Jwt;
use Spatie\LaravelData\Data;

class JwtData extends Data
{
    public function __construct(
        #[Jwt]
        public string $test
    ) {}
}
