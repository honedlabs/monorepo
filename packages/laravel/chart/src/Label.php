<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Style\HasBackgroundColor;
use Honed\Chart\Concerns\Style\HasBorderColor;
use Honed\Chart\Concerns\Style\HasBorderRadius;
use Honed\Chart\Concerns\Style\HasBorderType;
use Honed\Chart\Concerns\Style\HasBorderWidth;
use Honed\Chart\Concerns\Style\HasColor;
use Honed\Chart\Concerns\Style\HasDashOffset;
use Honed\Chart\Concerns\Style\HasFontFamily;
use Honed\Chart\Concerns\Style\HasFontSize;
use Honed\Chart\Concerns\Style\HasFontStyle;
use Honed\Chart\Concerns\Style\HasFontWeight;
use Honed\Chart\Concerns\Style\HasHeight;
use Honed\Chart\Concerns\Style\HasLineHeight;
use Honed\Chart\Concerns\Style\HasOverflow;
use Honed\Chart\Concerns\Style\HasPadding;
use Honed\Chart\Concerns\Style\HasShadowBlur;
use Honed\Chart\Concerns\Style\HasShadowColor;
use Honed\Chart\Concerns\Style\HasShadowOffset;
use Honed\Chart\Concerns\Style\HasWidth;

class Label extends Chartable
{
    use CanBeShown;
    use HasBackgroundColor;
    use HasBorderColor;
    use HasBorderRadius;
    use HasBorderType;
    use HasBorderWidth;
    use HasColor;
    use HasDashOffset;
    use HasFontFamily;
    use HasFontSize;
    use HasFontStyle;
    use HasFontWeight;
    use HasHeight;
    use HasLineHeight;
    use HasOverflow;
    use HasPadding;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;
    use HasWidth;

    /**
     * Get the representation of the label.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'color' => $this->getColor(),
            'fontStyle' => $this->getFontStyle(),
            'fontWeight' => $this->getFontWeight(),
            'fontFamily' => $this->getFontFamily(),
            'fontSize' => $this->getFontSize(),
            'lineHeight' => $this->getLineHeight(),
            'backgroundColor' => $this->getBackgroundColor(),
            'borderColor' => $this->getBorderColor(),
            'borderWidth' => $this->getBorderWidth(),
            'borderType' => $this->getBorderType(),
            'borderDashOffset' => $this->getDashOffset(),
            'borderRadius' => $this->getBorderRadius(),
            'padding' => $this->getPadding(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'overflow' => $this->getOverflow(),
        ];
    }
}
