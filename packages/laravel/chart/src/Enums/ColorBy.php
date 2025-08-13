<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum ColorBy: string
{
    case Series = 'series';
    case Data = 'data';
}
