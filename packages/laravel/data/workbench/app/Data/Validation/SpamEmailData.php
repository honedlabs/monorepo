<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\SpamEmail;
use Spatie\LaravelData\Data;

class SpamEmailData extends Data
{
    public function __construct(
        #[SpamEmail]
        public string $test
    ) {}
}
