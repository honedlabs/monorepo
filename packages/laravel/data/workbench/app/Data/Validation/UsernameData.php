<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Username;
use Spatie\LaravelData\Data;

class UsernameData extends Data
{
    public function __construct(
        #[Username]
        public string $test
    ) {}
}
