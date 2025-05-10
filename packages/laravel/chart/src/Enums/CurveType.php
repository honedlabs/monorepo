<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum CurveType: string
{
    case Basis = 'basis';
    case Linear = 'linear';
    case Step = 'step';
}