<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum ChartType: string
{
    case Line = 'line';
    case Bar = 'bar';
    case Pie = 'pie';
    case Heatmap = 'heatmap';
    case Radar = 'radar';
    case Sankey = 'sankey';
    case Scatter = 'scatter';
}