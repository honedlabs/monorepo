<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum GradientType: string
{
    case Linear = 'linear';
    case Radial = 'radial';
}