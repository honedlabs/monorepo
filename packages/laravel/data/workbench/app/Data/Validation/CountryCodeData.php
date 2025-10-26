<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\CountryCode;
use Spatie\LaravelData\Data;

class CountryCodeData extends Data
{
    public function __construct(
        #[CountryCode]
        public mixed $value
    ) {}
}
