<?php

declare(strict_types=1);

namespace Honed\Chart\Legend;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasItemGap;
use Honed\Chart\Concerns\HasItemHeight;
use Honed\Chart\Concerns\HasItemStyle;
use Honed\Chart\Concerns\HasItemWidth;
use Honed\Chart\Concerns\HasLineStyle;
use Honed\Chart\Concerns\HasOrientation;
use Honed\Chart\Concerns\HasTextStyle;
use Honed\Chart\Concerns\HasTooltip;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Legend\Concerns\HasLegendType;
use Honed\Chart\Style\Concerns\CanBeRotated;
use Honed\Chart\Style\Concerns\HasBackgroundColor;
use Honed\Chart\Style\Concerns\HasBorderColor;
use Honed\Chart\Style\Concerns\HasBorderRadius;
use Honed\Chart\Style\Concerns\HasBorderWidth;
use Honed\Chart\Style\Concerns\HasBottom;
use Honed\Chart\Style\Concerns\HasHeight;
use Honed\Chart\Style\Concerns\HasInactiveBorderColor;
use Honed\Chart\Style\Concerns\HasInactiveColor;
use Honed\Chart\Style\Concerns\HasInactiveWidth;
use Honed\Chart\Style\Concerns\HasLeft;
use Honed\Chart\Style\Concerns\HasPadding;
use Honed\Chart\Style\Concerns\HasRight;
use Honed\Chart\Style\Concerns\HasShadowBlur;
use Honed\Chart\Style\Concerns\HasShadowColor;
use Honed\Chart\Style\Concerns\HasShadowOffset;
use Honed\Chart\Style\Concerns\HasTop;
use Honed\Chart\Style\Concerns\HasWidth;
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
    use HasLeft;
    use HasTop;
    use HasRight;
    use HasBottom;
    use HasWidth;
    use HasHeight;
    use HasPadding;
    use HasItemGap;
    use HasItemWidth;
    use HasItemHeight;
    use HasItemStyle;
    use HasLineStyle;
    use CanBeRotated;
    use HasInactiveColor;
    use HasInactiveBorderColor;
    use HasInactiveWidth;
    use HasBackgroundColor;
    use HasBorderColor;
    use HasBorderRadius;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;
    use HasBorderWidth;

    /**
     * Create a new legend instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

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
            'left' => $this->getLeft(),
            'top' => $this->getTop(),
            'right' => $this->getRight(),
            'bottom' => $this->getBottom(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'orient' => $this->getOrientation(),
            // 'align' => $this->getAlign(),
            'padding' => $this->getPadding(),
            'itemGap' => $this->getItemGap(),
            'itemWidth' => $this->getItemWidth(),
            'itemHeight' => $this->getItemHeight(),
            'itemStyle' => $this->getItemStyle()?->toArray(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
            'symbolRotate' => $this->getRotation(),
            // 'selectedMode' => $this->getSelectedMode(),
            'inactiveColor' => $this->getInactiveColor(),
            'inactiveBorderColor' => $this->getInactiveBorderColor(),
            'inactiveBorderWidth' => $this->getInactiveWidth(),
            'textStyle' => $this->getTextStyle()?->toArray(),
            'tooltip' => $this->getTooltip()?->toArray(),
            'backgroundColor' => $this->getBackgroundColor(),
            'borderColor' => $this->getBorderColor(),
            'borderWidth' => $this->getBorderWidth(),
            'borderRadius' => $this->getBorderRadius(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            // 'animation' => $this->isAnimatable(),
            // 'animationDurationUpdate' => $this->getAnimationDurationUpdate(),
            // 'emphasis' => $this->getEmphasis()?->toArray(),
        ];
    }
}