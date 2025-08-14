<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Chart\Axis\Concerns\CanBeInside;
use Honed\Chart\Axis\Concerns\HasInterval;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Style\Concerns\CanBeRotated;
use Honed\Chart\Style\Concerns\HasBackgroundColor;
use Honed\Chart\Style\Concerns\HasBorderColor;
use Honed\Chart\Style\Concerns\HasColor;
use Honed\Chart\Style\Concerns\HasFontFamily;
use Honed\Chart\Style\Concerns\HasFontSize;
use Honed\Chart\Style\Concerns\HasFontStyle;
use Honed\Chart\Style\Concerns\HasFontWeight;
use Honed\Chart\Style\Concerns\HasMargin;
use Honed\Chart\Support\Concerns\HasRotation;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class AxisLabel extends Primitive implements NullsAsUndefined
{
    use CanBeInside;
    use HasRotation;
    use HasMargin;
    use CanBeShown;
    use HasBackgroundColor;
    use HasBorderColor;
    use HasColor;
    use HasFontFamily;
    use HasFontSize;
    use HasFontStyle;
    use HasFontWeight;
    use HasInterval;

    /**
     * Create a new axis label instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the array representation of the axis label.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'interval' => $this->getInterval(),
            'inside' => $this->isInside(),
            'rotate' => $this->getRotation(),
            'margin' => $this->getMargin(),
            // 'showMinLabel' => $this->isShowingMinLabel(),
            // 'showMaxLabel' => $this->isShowingMaxLabel(),
            // 'alignMinLabel' => $this->isAligningMinLabel(),
            // 'alignMaxLabel' => $this->isAligningMaxLabel(),
            // 'hideOverlap' => $this->isHidingOverlap(),
            'color' => $this->getColor(),
            'fontStyle' => $this->getFontStyle(),
            'fontWeight' => $this->getFontWeight(),
            'fontFamily' => $this->getFontFamily(),
            'fontSize' => $this->getFontSize(),
            // 'align' => $this->getAlign(),
            // 'verticalAlign' => $this->getVerticalAlign(),
            // 'lineHeight' => $this->getLineHeight(),
            // 'backgroundColor' => $this->getBackgroundColor(),
            // 'borderColor' => $this->getBorderColor(),
            // 'borderWidth' => $this->getBorderWidth(),
            // 'borderType' => $this->getBorderType(),
            // 'borderDashOffset' => $this->getDashOffset(),
            // 'borderRadius' => $this->getBorderRadius(),
            // 'padding' => $this->getPadding(),
            // 'shadowColor' => $this->getShadowColor(),
            // 'shadowBlur' => $this->getShadowBlur(),
            // 'shadowOffsetX' => $this->getShadowOffsetX(),
            // 'shadowOffsetY' => $this->getShadowOffsetY(),
            // 'width' => $this->getWidth(),
            // 'height' => $this->getHeight(),
            // 'overflow' => $this->getOverflow(),
            // 'textBorderColor' => $this->getTextBorderColor(),
            // 'textBorderWidth' => $this->getTextBorderWidth(),
            // 'textBorderType' => $this->getTextBorderType(),
            // 'textBorderDashOffset' => $this->getTextBorderDashOffset(),
            // 'textBorderRadius' => $this->getTextBorderRadius(),
            // 'textPadding' => $this->getTextPadding(),
            // 'textShadowColor' => $this->getTextShadowColor(),
            // 'textShadowBlur' => $this->getTextShadowBlur(),
            // 'textShadowOffsetX' => $this->getTextShadowOffsetX(),
            // 'overflow' => $this->getOverflow(),
        ];
    }
}
