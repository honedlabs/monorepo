<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Cidr;
use Spatie\LaravelData\Data;

class CidrData extends Data
{
    public function __construct(
        #[Cidr]
        public string $test
    ) {}
}
