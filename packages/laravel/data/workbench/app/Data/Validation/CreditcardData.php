<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Creditcard;
use Spatie\LaravelData\Data;

class CreditcardData extends Data
{
    public function __construct(
        #[Creditcard]
        public string $test
    ) {}
}
