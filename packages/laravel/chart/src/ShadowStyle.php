<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Style\HasColor;
use Honed\Chart\Concerns\Style\HasOpacity;
use Honed\Chart\Concerns\Style\HasShadowBlur;
use Honed\Chart\Concerns\Style\HasShadowOffset;

class ShadowStyle extends Chartable
{
    use HasColor;
    use HasOpacity;
    use HasShadowBlur;
    use HasShadowOffset;

    /**
     * Get the array representation of the shadow style.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'color' => $this->getColor(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'opacity' => $this->getOpacity(),
        ];
    }
}
