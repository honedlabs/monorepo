<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Focus: string
{
    case None = 'none';
    case Self = 'self';
    case Series = 'series';
}