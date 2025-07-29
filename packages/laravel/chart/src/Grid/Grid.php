<?php

declare(strict_types=1);

namespace Honed\Chart\Grid;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasTooltip;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Grid extends Primitive implements NullsAsUndefined
{
    use HasId;
    use CanBeShown;
    use HasZAxis;
    use HasTooltip;

    /**
     * Get the representation of the grid.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'z' => $this->getZ(),
            'zLevel' => $this->getZLevel(),
            // 'left' => $this->getLeft(),
            // 'top' => $this->getTop(),
            // 'right' => $this->getRight(),
            // 'bottom' => $this->getBottom(),
            // 'width' => $this->getWidth(),
            // 'height' => $this->getHeight(),
            // 'containLabel' => $this->getContainLabel(),
            // 'backgroundColor' => $this->getBackgroundColor(),
            // 'borderColor' => $this->getBorderColor(),
            // 'borderWidth' => $this->getBorderWidth(),
            // 'shadowBlur' => $this->getShadowBlur(),
            // 'shadowColor' => $this->getShadowColor(),
            // 'shadowOffsetX' => $this->getShadowOffsetX(),
            // 'shadowOffsetY' => $this->getShadowOffsetY(),
            'tooltip' => $this->getTooltip()?->toArray(),
        ];
    }
}