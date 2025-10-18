<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Vimeo;
use Spatie\LaravelData\Data;

class VimeoData extends Data
{
    public function __construct(
        #[Vimeo]
        public string $test
    ) {}
}
