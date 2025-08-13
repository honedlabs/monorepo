<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum StackStrategy: string
{
    case SameSign = 'samesign';
    case All = 'all';
    case Positive = 'positive';
    case Negative = 'negative';
}
