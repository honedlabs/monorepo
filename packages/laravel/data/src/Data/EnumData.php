<?php

declare(strict_types=1);

namespace Honed\Data\Data;

use Spatie\LaravelData\Resource;

class EnumData extends Resource
{
    public function __construct(
        public string $label,
        public string|int $value
    ) {}

    // public static function normalizers
}
