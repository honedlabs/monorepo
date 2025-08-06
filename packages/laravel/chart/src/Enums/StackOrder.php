<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum StackOrder: string
{
    case Ascending = 'seriesAsc';
    case Descending = 'seriesDesc';
}