<?php

declare(strict_types=1);

namespace Honed\Action\Http\Data;

use Honed\Core\Contracts\Transferable;

abstract class ActionData implements Transferable
{
    public function __construct(
        public readonly string $name,
    ) {}
}
