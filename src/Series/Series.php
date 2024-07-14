<?php

namespace Conquest\Chart\Series;

use Conquest\Chart\Series\Concerns\HasChartType;
use Conquest\Core\Primitive;

class Series extends Primitive
{
    use HasChartType;

    public function toArray(): array
    {
        return [
            'type' => $this->type?->value,
        ];
    }

    public function infersType()
    {
        
    }
}
