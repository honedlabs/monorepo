<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum BlurScope: string
{
    case CoordinateSystem = 'coordinateSystem';
    case Series = 'series';
    case Global = 'global';
}