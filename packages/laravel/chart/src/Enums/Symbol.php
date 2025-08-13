<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Symbol: string
{
    case EmptyCircle = 'emptyCircle';
    case Circle = 'circle';
    case Rect = 'rect';
    case RoundRect = 'roundRect';
    case Triangle = 'triangle';
    case Diamond = 'diamond';
    case Pin = 'pin';
    case Arrow = 'arrow';
    case None = 'none';
}
