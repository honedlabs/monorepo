<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Chartable;
use Honed\Chart\Enums\LegendType;

class Legend extends Chartable
{
    // use HasRotation;
    use CanBeShown;
    // use HasBackgroundColor;
    // use HasBorderColor;
    // use HasBorderRadius;
    // use HasBorderWidth;
    // use HasBottom;
    // use HasHeight;
    use HasId;
    // use HasInactiveBorderColor;
    // use HasInactiveColor;
    // use HasInactiveWidth;
    // use HasItemGap;
    // use HasItemHeight;
    // use HasItemStyle;
    // use HasItemWidth;
    // use HasLeft;
    // use HasLineStyle;
    // use HasOrientation;
    // use HasPadding;
    // use HasRight;
    // use HasShadowBlur;
    // use HasShadowColor;
    // use HasShadowOffset;
    // use HasTextStyle;
    // use HasTooltip;
    // use HasTop;
    // use HasWidth;
    // use HasZAxis;

    /**
     * The type of legend.
     * 
     * @var ?\Honed\Chart\Enums\LegendType
     */
    protected $type;

    /**
     * Set the type of legend.
     *
     * @return $this
     * 
     * @throws \ValueError
     * @throws \TypeError
     */
    public function type(string|LegendType $value): static
    {
        $this->type = is_string($value) ? LegendType::from($value) : $value;

        return $this;
    }

    /**
     * Set the type of legend to be plain.
     *
     * @return $this
     * 
     * @throws \ValueError
     * @throws \TypeError
     */
    public function plain(): static
    {
        return $this->type(LegendType::Plain);
    }
    
    /**
     * Set the type of legend to be scroll.
     *
     * @return $this
     * 
     * @throws \ValueError
     * @throws \TypeError
     */
    public function scroll(): static
    {
        return $this->type(LegendType::Scroll);
    }

    /**
     * Get the type of legend.
     *
     * @return ?\Honed\Chart\Enums\LegendType
     */
    public function getType(): ?LegendType
    {
        return $this->type;
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
            // 'zLevel' => $this->getZLevel(),
            // 'z' => $this->getZ(),
            // 'left' => $this->getLeft(),
            // 'top' => $this->getTop(),
            // 'right' => $this->getRight(),
            // 'bottom' => $this->getBottom(),
            // 'width' => $this->getWidth(),
            // 'height' => $this->getHeight(),
            // 'orient' => $this->getOrientation(),
            // 'align' => $this->getAlign(),
            // 'padding' => $this->getPadding(),
            // 'itemGap' => $this->getItemGap(),
            // 'itemWidth' => $this->getItemWidth(),
            // 'itemHeight' => $this->getItemHeight(),
            // 'itemStyle' => $this->getItemStyle()?->toArray(),
            // 'lineStyle' => $this->getLineStyle()?->toArray(),
            // 'symbolRotate' => $this->getRotation(),
            // 'selectedMode' => $this->getSelectedMode(),
            // 'inactiveColor' => $this->getInactiveColor(),
            // 'inactiveBorderColor' => $this->getInactiveBorderColor(),
            // 'inactiveBorderWidth' => $this->getInactiveWidth(),
            // 'textStyle' => $this->getTextStyle()?->toArray(),
            // 'tooltip' => $this->getTooltip()?->toArray(),
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
            // 'emphasis' => $this->getEmphasis()?->toArray(),
        ];
    }
}
