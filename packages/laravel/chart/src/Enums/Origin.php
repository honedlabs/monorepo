<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Origin: string
{
    case Auto = 'auto';
    case Start = 'start';
    case End = 'end';
}
