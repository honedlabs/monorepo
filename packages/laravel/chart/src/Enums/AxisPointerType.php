<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum AxisPointerType: string
{
    case Line = 'line';
    case Shadow = 'shadow';
    case None = 'none';
}
