<?php

declare(strict_types=1);

namespace Honed\Refine\Enums;

enum Clause: string
{
    case Is = '=';
    case IsNot = '!=';
    case Contains = 'contains';
    case StartsWith = 'starts_with';
    case EndsWith = 'ends_with';
    case Between = 'between';
    case In = 'in';
    case NotIn = 'not_in';
    case GreaterThan = '>';
    case GreaterThanOrEqual = '>=';
    case LessThan = '<';
    case LessThanOrEqual = '<=';
}
