<?php

declare(strict_types=1);

namespace Honed\Action\Transfers;

class BulkData
{
    public function __construct(
        public readonly string $name,
        public readonly string $value,
        public readonly string $label,
    ) {}

    // public static function from($request)
    // {
    //     return new static(

    //     )
    // }
}