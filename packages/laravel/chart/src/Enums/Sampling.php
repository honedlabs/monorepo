<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Sampling: string
{
    case Lttb = 'lttb';
    case Average = 'average';
    case Max = 'max';
    case Min = 'min';
    case MinMax = 'minmax';
    case Sum = 'sum';
}
