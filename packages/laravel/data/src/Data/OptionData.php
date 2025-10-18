<?php

declare(strict_types=1);

namespace Honed\Data\Data;

use Spatie\LaravelData\Resource;

class OptionData extends Resource
{
    public function __construct(
        public string $label,
        public string|int|bool|null $value
    ) {}
}
