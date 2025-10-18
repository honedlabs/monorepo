<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\DataUri;
use Spatie\LaravelData\Data;

class DataUriData extends Data
{
    public function __construct(
        #[DataUri]
        public string $test
    ) {}
}
