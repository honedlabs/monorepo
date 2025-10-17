<?php

declare(strict_types=1);

namespace Honed\Data\Data;

use Spatie\LaravelData\Data;

class OptionData extends Data
{
    public function __construct(
        public string $label,
        public string|int $value
    ) {}
    
}