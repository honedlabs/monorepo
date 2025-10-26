<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Attributes\FromRequestUserAgent;
use Spatie\LaravelData\Data;

class UserAgentData extends Data
{
    public function __construct(
        #[FromRequestUserAgent]
        public ?string $userAgent
    ) {}
}
