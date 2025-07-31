<?php

declare(strict_types=1);

namespace Honed\Chart\Legend;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasOrientation;
use Honed\Chart\Concerns\HasTextStyle;
use Honed\Chart\Concerns\HasTooltip;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Legend\Concerns\HasLegendType;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Legend extends Primitive implements NullsAsUndefined
{
    use HasId;
    use CanBeShown;
    use HasLegendType;
    use HasZAxis;
    use HasOrientation;
    use HasTextStyle;
    use HasTooltip;
    // use HasItemStyle;

    /**
     * Get the representation of the legend.
     * 
     * @return array<string,mixed>
     */
    protected function representation(): array
    {
        return [
            'type' => $this->getType(),
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'zLevel' => $this->getZLevel(),
            'z' => $this->getZ(),
            // 'left' => $this->getLeft(),
            // 'top' => $this->getTop(),
            // 'right' => $this->getRight(),
            // 'bottom' => $this->getBottom(),
            // 'width' => $this->getWidth(),
            'orient' => $this->getOrientation(),
            // 'align' => $this->getAlign(),
            // 'padding' => $this->getPadding(),
            // 'itemGap' => $this->getItemGap(),
            // 'itemWidth' => $this->getItemWidth(),
            // 'itemHeight' => $this->getItemHeight(),
            // 'itemStyle' => $this->getItemStyle()?->toArray(),
            // 'lineStyle' => $this->getLineStyle()?->toArray(),
            // 'symbolRotate' => $this->getSymbolRotate(),
            // 'selectedMode' => $this->getSelectedMode(),
            // 'inactiveColor' => $this->getInactiveColor(),
            // 'inactiveBorderColor' => $this->getInactiveBorderColor(),
            // 'inactiveBorderWidth' => $this->getInactiveBorderWidth(),
            'textStyle' => $this->getTextStyle()?->toArray(),
            'tooltip' => $this->getTooltip()?->toArray(),
            // 'backgroundColor' => $this->getBackgroundColor(),
            // 'borderColor' => $this->getBorderColor(),
            // 'borderWidth' => $this->getBorderWidth(),
            // 'borderRadius' => $this->getBorderRadius(),
            // 'shadowBlur' => $this->getShadowBlur(),
            // 'shadowColor' => $this->getShadowColor(),
            // 'shadowOffsetX' => $this->getShadowOffsetX(),
            // 'shadowOffsetY' => $this->getShadowOffsetY(),
            // 'animation' => $this->isAnimatable(),
            // 'animationDurationUpdate' => $this->getAnimationDurationUpdate(),
            // 'Emphasis' => $this->getEmphasis()?->toArray(),
        ];
    }
}