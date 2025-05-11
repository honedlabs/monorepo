<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\HasBulletShape;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\HasOrientation;
use Honed\Chart\Concerns\HasShape;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Macroable;
use JsonSerializable;

class Legend implements Arrayable, JsonSerializable
{
    use Macroable;
    use HasColor;
    use HasOrientation;
    use HasShape;

    // The labels as a string property to extract from data

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return [
            'items',
            'labelFontSize',
            'labelMaxWidht',
            'bulletSize',
            // ...$this->bulletShapeToArray(),
            'orientation',

        ];
    }
}