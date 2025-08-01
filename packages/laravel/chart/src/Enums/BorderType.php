<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum BorderType: string
{
    case Solid = 'solid';
    case Dashed = 'dashed';
    case Dotted = 'dotted';
}