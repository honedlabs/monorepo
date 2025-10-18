<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Filename;
use Spatie\LaravelData\Data;

class FilenameData extends Data
{
    public function __construct(
        #[Filename]
        public string $test
    ) {}
}
