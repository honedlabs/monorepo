<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\CreditCard;
use Spatie\LaravelData\Data;

class CreditCardData extends Data
{
    public function __construct(
        #[CreditCard]
        public string $test
    ) {}
}
