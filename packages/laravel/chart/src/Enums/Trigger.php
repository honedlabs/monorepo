<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Trigger: string
{
    case Item = 'item';
    case Axis = 'axis';
    case None = 'none';
}
