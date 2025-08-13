<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Location: string
{
    case Start = 'start';
    case Center = 'center';
    case Middle = 'middle';
    case End = 'end';
}
