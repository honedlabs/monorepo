<?php

declare(strict_types=1);

namespace Workbench\App\Classes;

use Honed\Core\Concerns\HasType;
use Honed\Core\SimplePrimitive;

class SimpleComponent extends SimplePrimitive
{
    use HasType;

    /**
     * Get the representation of the instance.
     *
     * @return array<string,mixed>
     */
    protected function representation(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
