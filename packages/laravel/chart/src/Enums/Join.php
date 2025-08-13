<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Join: string
{
    case Bevel = 'bevel';
    case Round = 'round';
    case Miter = 'miter';
}
