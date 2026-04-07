<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Style\HasColor;
use Honed\Chart\Concerns\Style\HasOpacity;
use Honed\Chart\Concerns\Style\HasOrigin;
use Honed\Chart\Concerns\Style\HasShadowBlur;
use Honed\Chart\Concerns\Style\HasShadowColor;
use Honed\Chart\Concerns\Style\HasShadowOffset;

class AreaStyle extends Chartable
{
    use HasColor;
    use HasOpacity;
    use HasOrigin;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;

    /**
     * Get the representation of the area style.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'color' => $this->getColor(),
            'origin' => $this->getOrigin(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'opacity' => $this->getOpacity(),
        ];
    }
}
