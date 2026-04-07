<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Style\HasBorderType;
use Honed\Chart\Concerns\Style\HasCap;
use Honed\Chart\Concerns\Style\HasColor;
use Honed\Chart\Concerns\Style\HasDashOffset;
use Honed\Chart\Concerns\Style\HasInactiveColor;
use Honed\Chart\Concerns\Style\HasInactiveWidth;
use Honed\Chart\Concerns\Style\HasJoin;
use Honed\Chart\Concerns\Style\HasOpacity;
use Honed\Chart\Concerns\Style\HasShadowBlur;
use Honed\Chart\Concerns\Style\HasShadowColor;
use Honed\Chart\Concerns\Style\HasShadowOffset;
use Honed\Chart\Concerns\Style\HasWidth;

class LineStyle extends Chartable
{
    use HasBorderType;
    use HasCap;
    use HasColor;
    use HasDashOffset;
    use HasInactiveColor;
    use HasInactiveWidth;
    use HasJoin;
    use HasOpacity;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;
    use HasWidth;

    /**
     * Get the representation of the line style.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'color' => $this->getColor(),
            'width' => $this->getWidth(),
            'type' => $this->getBorderType(),
            'dashOffset' => $this->getDashOffset(),
            'cap' => $this->getCap(),
            'join' => $this->getJoin(),
            'miterLimit' => $this->getMiterLimit(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'opacity' => $this->getOpacity(),
            'inactiveColor' => $this->getInactiveColor(),
            'inactiveWidth' => $this->getInactiveWidth(),
        ];
    }
}
