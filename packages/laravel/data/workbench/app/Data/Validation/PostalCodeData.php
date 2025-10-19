<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\PostalCode;
use Spatie\LaravelData\Data;

class PostalCodeData extends Data
{
    public function __construct(
        #[PostalCode('gb')]
        public string $test
    ) {}
}
