<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum ChartType: string
{
    case Line = 'line';
    case Bar = 'bar';
    case Pie = 'pie';
    case Doughnut = 'doughnut';
    case Radar = 'radar';
    case Polar = 'polar';
    case Scatter = 'scatter';
}