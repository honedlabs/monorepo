<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\MaxWords;
use Spatie\LaravelData\Data;

class MaxWordsData extends Data
{
    public function __construct(
        #[MaxWords(2)]
        public mixed $value
    ) {}
}
