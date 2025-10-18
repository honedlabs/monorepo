<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Slug;
use Spatie\LaravelData\Data;

class SlugData extends Data
{
    public function __construct(
        #[Slug]
        public string $test
    ) {}
}
