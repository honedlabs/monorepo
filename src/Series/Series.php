<?php

namespace Conquest\Chart\Series;

use Conquest\Chart\Series\Concerns\HasChartType;

class Series
{
    use HasChartType;

    public function toArray(): array
    {
        return [
            'type' => $this->type?->value,
        ];
    }
}
