<?php

declare(strict_types=1);

namespace Honed\Refine\Enums;

enum Clause: string
{
    case Is = 'is';
    case IsNot = 'is not';
    case Contains = 'contains';
    case StartsWith = 'starts';
    case EndsWith = 'ends';
    case Between = 'between';
    case In = 'in';
    case NotIn = 'not in';
    case GreaterThan = '>';
    case GreaterThanOrEqual = '>=';
    case LessThan = '<';
    case LessThanOrEqual = '<=';
}
