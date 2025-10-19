<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\CleanHtml;
use Spatie\LaravelData\Data;

class CleanHtmlData extends Data
{
    public function __construct(
        #[CleanHtml]
        public string $test
    ) {}
}
