<?php

declare(strict_types=1);

namespace Honed\Chart\Label;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Label\Concerns\HasDistance;
use Honed\Chart\Style\Concerns\CanBeRotated;
use Honed\Chart\Style\Concerns\HasBackgroundColor;
use Honed\Chart\Style\Concerns\HasBorderColor;
use Honed\Chart\Style\Concerns\HasBorderRadius;
use Honed\Chart\Style\Concerns\HasBorderType;
use Honed\Chart\Style\Concerns\HasBorderWidth;
use Honed\Chart\Style\Concerns\HasDashOffset;
use Honed\Chart\Style\Concerns\HasFontFamily;
use Honed\Chart\Style\Concerns\HasFontSize;
use Honed\Chart\Style\Concerns\HasFontStyle;
use Honed\Chart\Style\Concerns\HasFontWeight;
use Honed\Chart\Style\Concerns\HasHeight;
use Honed\Chart\Style\Concerns\HasLineHeight;
use Honed\Chart\Style\Concerns\HasOverflow;
use Honed\Chart\Style\Concerns\HasPadding;
use Honed\Chart\Style\Concerns\HasShadowBlur;
use Honed\Chart\Style\Concerns\HasShadowColor;
use Honed\Chart\Style\Concerns\HasShadowOffset;
use Honed\Chart\Style\Concerns\HasWidth;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Label extends Primitive implements NullsAsUndefined
{
    use CanBeRotated;
    use CanBeShown;
    use HasBackgroundColor;
    use HasBorderColor;
    use HasBorderRadius;
    use HasBorderType;
    use HasBorderWidth;
    use HasDashOffset;
    use HasDistance;
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
     * Create a new label instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the label.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            // 'position' => $this->getPosition(),
            'distance' => $this->getDistance(),
            'rotate' => $this->getRotation(),
            // 'offset' => $this->getOffset(),
            // 'minMargin' => $this->getMinMargin(),
            'fontStyle' => $this->getFontStyle(),
            'fontWeight' => $this->getFontWeight(),
            'fontFamily' => $this->getFontFamily(),
            'fontSize' => $this->getFontSize(),
            // 'align' => $this->getAlign(),
            // 'verticalAlign' => $this->getVerticalAlign(),
            'lineHeight' => $this->getLineHeight(),
            'backgroundColor' => $this->getBackgroundColor(),
            'borderColor' => $this->getBorderColor(),
            'borderWidth' => $this->getBorderWidth(),
            'borderType' => $this->getBorderType(),
            'borderDashOffset' => $this->getDashOffset(),
            'padding' => $this->getPadding(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            // 'textBorderColor' => $this->getTextBorderColor(),
            // 'textBorderWidth' => $this->getTextBorderWidth(),
            // 'textBorderType' => $this->getTextBorderType(),
            // 'textBorderDashOffset' => $this->getTextBorderDashOffset(),
            // 'textBorderColor' => $this->getTextBorderColor(),
            // 'textBorderShadowColor' => $this->getTextBorderShadowColor(),
            // 'textBorderShadowBlur' => $this->getTextBorderShadowBlur(),
            // 'textBorderShadowOffsetX' => $this->getTextBorderShadowOffsetX(),
            // 'textBorderShadowOffsetY' => $this->getTextBorderShadowOffsetY(),
            'overflow' => $this->getOverflow(),
            // 'ellipsis' => $this->getEllipsis(),
        ];
    }
}
