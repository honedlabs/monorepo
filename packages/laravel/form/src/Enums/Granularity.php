<?php

declare(strict_types=1);

namespace Honed\Form\Enums;

enum Granularity: string
{
    case Day = 'day';
    case Hour = 'hour';
    case Minute = 'minute';
    case Second = 'second';
}
