<?php

declare(strict_types=1);

namespace Honed\Chart\Support;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Style\Concerns\HasColor;
use Honed\Chart\Style\Concerns\HasFontFamily;
use Honed\Chart\Style\Concerns\HasFontSize;
use Honed\Chart\Style\Concerns\HasFontStyle;
use Honed\Chart\Style\Concerns\HasFontWeight;
use Honed\Chart\Style\Concerns\HasLineHeight;
use Honed\Chart\Support\Concerns\CanBeAligned;
use Honed\Chart\Support\Concerns\CanBeVerticallyAligned;
use Honed\Chart\Support\Concerns\HasDistance;
use Honed\Chart\Support\Concerns\HasOffset;
use Honed\Chart\Support\Concerns\HasRotation;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class SelectorLabel extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use HasDistance;
    use HasRotation;
    use HasOffset;
    use HasColor;
    use HasFontStyle;
    use HasFontWeight;
    use HasFontFamily;
    use HasFontSize;
    use CanBeAligned;
    use CanBeVerticallyAligned;
    use HasLineHeight;

    /**
     * Create a new selector label instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the array representation of the selector label.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'distance' => $this->getDistance(),
            'rotate' => $this->getRotation(),
            'offset' => $this->getOffset(),
            'color' => $this->getColor(),
            'fontStyle' => $this->getFontStyle(),
            'fontWeight' => $this->getFontWeight(),
            'fontFamily' => $this->getFontFamily(),
            'fontSize' => $this->getFontSize(),
            'align' => $this->getAlign(),
            'verticalAlign' => $this->getVerticalAlign(),
            // 'lineHeight' => $this->getLineHeight(),
            // 'backgroundColor' => $this->getBackgroundColor(),
            // 'borderColor' => $this->getBorderColor(),
            // 'borderWidth' => $this->getBorderWidth(),
            // 'borderType' => $this->getBorderType(),
            // 'borderDashOffset' => $this->getBorderDashOffset(),
            // 'borderRadius' => $this->getBorderRadius(),
            // 'padding' => $this->getPadding(),
            // 'shadowColor' => $this->getShadowColor(),
            // 'shadowBlur' => $this->getShadowBlur(),
            // 'shadowOffsetX' => $this->getShadowOffsetX(),
            // 'shadowOffsetY' => $this->getShadowOffsetY(),
            // 'width' => $this->getWidth(),
            // 'height' => $this->getHeight(),
            // 'textBorderColor' => $this->getTextBorderColor(),
            // 'textBorderWidth' => $this->getTextBorderWidth(),
            // 'textBorderType' => $this->getTextBorderType(),
            // 'textBorderDashOffset' => $this->getTextBorderDashOffset(),
            // 'textShadowColor' => $this->getTextShadowColor(),
            // 'textShadowBlur' => $this->getTextShadowBlur(),
            // 'textShadowOffsetX' => $this->getTextShadowOffsetX(),
            // 'textShadowOffsetY' => $this->getTextShadowOffsetY(),
            // 'overflow' => $this->getOverflow(),
            // 'ellipsis' => null
        ];
    }
}