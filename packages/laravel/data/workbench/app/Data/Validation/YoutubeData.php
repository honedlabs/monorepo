<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Youtube;
use Spatie\LaravelData\Data;

class YoutubeData extends Data
{
    public function __construct(
        #[Youtube]
        public string $test
    ) {}
}
