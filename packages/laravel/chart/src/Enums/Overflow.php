<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Overflow: string
{
    case Truncate = 'truncate';
    case Break = 'break';
    case BreakAll = 'breakAll';
}
