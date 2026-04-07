<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Components\HasLineStyle;
use Honed\Chart\Concerns\LabelLine\HasLength;
use Honed\Chart\Concerns\LabelLine\HasLength2;
use Honed\Chart\Concerns\LabelLine\HasSmooth;

class LabelLine extends Chartable
{
    use CanBeShown;
    use HasLength;
    use HasLength2;
    use HasLineStyle;
    use HasSmooth;

    /**
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'length' => $this->getLength(),
            'length2' => $this->getLength2(),
            'smooth' => $this->getSmooth(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
        ];
    }
}
