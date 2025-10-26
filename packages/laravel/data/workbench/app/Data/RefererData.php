<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Attributes\FromRequestHeader;
use Spatie\LaravelData\Data;

class RefererData extends Data
{
    public function __construct(
        #[FromRequestHeader('referer')]
        public ?string $referer
    ) {}
}
