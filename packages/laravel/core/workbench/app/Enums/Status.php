<?php

declare(strict_types=1);

namespace Workbench\App\Enums;

enum Status: int
{
    case Available = 0;
    case Unavailable = 1;
    case ComingSoon = 2;
}
