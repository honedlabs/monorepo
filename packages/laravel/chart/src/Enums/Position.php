<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Position: string
{
    case Top = 'top';
    case Left = 'left';
    case Right = 'right';
    case Bottom = 'bottom';
    case Inside = 'inside';
    case InsideLeft = 'insideLeft';
    case InsideRight = 'insideRight';
    case InsideTop = 'insideTop';
    case InsideBottom = 'insideBottom';
    case InsideTopLeft = 'insideTopLeft';
    case InsideTopRight = 'insideTopRight';
    case InsideBottomLeft = 'insideBottomLeft';
    case InsideBottomRight = 'insideBottomRight';
}
