<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Attributes\FromSession;
use Spatie\LaravelData\Data;

class SessionData extends Data
{
    public function __construct(
        #[FromSession('test')]
        public mixed $test
    ) {}
}