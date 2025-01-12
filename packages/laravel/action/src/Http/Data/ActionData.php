<?php

declare(strict_types=1);

namespace Honed\Action\Http\Data;

use Honed\Core\Contracts\Transfer;

abstract class ActionData implements Transfer
{
    public function __construct(
        public readonly string $name,
    ) {}
}
