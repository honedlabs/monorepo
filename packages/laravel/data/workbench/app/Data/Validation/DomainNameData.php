<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\DomainName;
use Spatie\LaravelData\Data;

class DomainNameData extends Data
{
    public function __construct(
        #[DomainName]
        public string $test
    ) {}
}
