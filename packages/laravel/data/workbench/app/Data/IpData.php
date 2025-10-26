<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Attributes\FromRequestIp;
use Spatie\LaravelData\Data;

class IpData extends Data
{
    public function __construct(
        #[FromRequestIp]
        public ?string $ip
    ) {}
}
