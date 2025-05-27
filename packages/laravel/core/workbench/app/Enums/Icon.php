<?php

namespace Workbench\App\Enums;

use Honed\Core\Contracts\WithIcon;

enum Icon: int implements WithIcon
{
    case ChevronDown = 0;
    case ChevronUp = 1;

    public function icon()
    {
        return match ($this) {
            self::ChevronDown => 'chevron-down',
            self::ChevronUp => 'chevron-up',
        };
    }
}
