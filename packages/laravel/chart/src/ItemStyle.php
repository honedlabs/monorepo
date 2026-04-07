<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Style\HasBorderColor;
use Honed\Chart\Concerns\Style\HasBorderRadius;
use Honed\Chart\Concerns\Style\HasBorderType;
use Honed\Chart\Concerns\Style\HasBorderWidth;
use Honed\Chart\Concerns\Style\HasCap;
use Honed\Chart\Concerns\Style\HasColor;
use Honed\Chart\Concerns\Style\HasDashOffset;
use Honed\Chart\Concerns\Style\HasJoin;
use Honed\Chart\Concerns\Style\HasOpacity;
use Honed\Chart\Concerns\Style\HasShadowBlur;
use Honed\Chart\Concerns\Style\HasShadowColor;
use Honed\Chart\Concerns\Style\HasShadowOffset;

class ItemStyle extends Chartable
{
    use HasBorderColor;
    use HasBorderRadius;
    use HasBorderType;
    use HasBorderWidth;
    use HasCap;
    use HasColor;
    use HasDashOffset;
    use HasJoin;
    use HasOpacity;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;

    /**
     * Get the representation of the item style.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'color' => $this->getColor(),
            'borderColor' => $this->getBorderColor(),
            'borderWidth' => $this->getBorderWidth(),
            'borderType' => $this->getBorderType(),
            'borderDashOffset' => $this->getDashOffset(),
            'borderCap' => $this->getCap(),
            'borderJoin' => $this->getJoin(),
            'borderMiterLimit' => $this->getMiterLimit(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'opacity' => $this->getOpacity(),
            'borderRadius' => $this->getBorderRadius(),
            // 'decal' => $this->getDecal(),
        ];
    }
}
