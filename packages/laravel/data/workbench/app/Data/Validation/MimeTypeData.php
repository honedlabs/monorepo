<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\MimeType;
use Spatie\LaravelData\Data;

class MimeTypeData extends Data
{
    public function __construct(
        #[MimeType]
        public string $test
    ) {}
}
