<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Attributes\Validation\CamelCase;
use Spatie\LaravelData\Data;

class CamelCaseData extends Data
{
    public function __construct(
        #[CamelCase]
        public string $name
    ) {}
}