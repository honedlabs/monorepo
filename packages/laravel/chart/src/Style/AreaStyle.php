<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class AreaStyle extends Primitive implements NullsAsUndefined
{
    protected function representation(): array
    {
        return [
            'color',
            'shadowBlur',
            'shadowColor',
            'shadowOffsetX',
            'shadowOffsetY',
            'opacity',
        ];
    }
}