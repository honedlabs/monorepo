<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum LegendType: string
{
    case Simple = 'plain';
    case Scroll = 'scroll';
}