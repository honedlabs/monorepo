<?php

declare(strict_types=1);

namespace Honed\Action\Transfers;

class BulkData implements Transfers
{
    public function __construct(
        public readonly $name,
        public readonly $value,
        public readonly $label,
    ) {}

    // public static function from($request)
    // {
    //     return new static(

    //     )
    // }
}