<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Currency;
use Spatie\LaravelData\Data;

class CurrencyData extends Data
{
    public function __construct(
        #[Currency]
        public mixed $value
    ) {}
}
