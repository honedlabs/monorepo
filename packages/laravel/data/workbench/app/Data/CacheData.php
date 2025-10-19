<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Attributes\FromCache;
use Spatie\LaravelData\Data;

class CacheData extends Data
{
    public function __construct(
        #[FromCache('test')]
        public mixed $test
    ) {}
}
