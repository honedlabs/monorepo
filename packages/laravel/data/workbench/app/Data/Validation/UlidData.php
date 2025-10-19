<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

class UlidData extends Data
{
    public function __construct(
        #[Ulid]
        public string $test
    ) {}
}
