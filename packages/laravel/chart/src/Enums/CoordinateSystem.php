<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum CoordinateSystem: string
{
    case Cartesian = 'cartesian2d';
    case Polar = 'polar';
}
