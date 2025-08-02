<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Shape: string
{
    case Circle = 'circle';
    case Cross = 'cross';
    case Diamond = 'diamond';
    case Line = 'line';
    case Square = 'square';
    case Star = 'star';
    case Triangle = 'triangle';
    case Wye = 'wye';
}

