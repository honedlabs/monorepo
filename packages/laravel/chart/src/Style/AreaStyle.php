<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Chartable;
use Honed\Chart\Style\Concerns\HasColor;
use Honed\Chart\Style\Concerns\HasOpacity;
use Honed\Chart\Style\Concerns\HasOrigin;
use Honed\Chart\Style\Concerns\HasShadowBlur;
use Honed\Chart\Style\Concerns\HasShadowColor;
use Honed\Chart\Style\Concerns\HasShadowOffset;

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
