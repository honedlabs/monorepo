<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Chartable;
use Honed\Chart\Style\Concerns\HasBorderColor;
use Honed\Chart\Style\Concerns\HasBorderType;
use Honed\Chart\Style\Concerns\HasBorderWidth;
use Honed\Chart\Style\Concerns\HasColor;
use Honed\Chart\Style\Concerns\HasFontFamily;
use Honed\Chart\Style\Concerns\HasFontSize;
use Honed\Chart\Style\Concerns\HasFontStyle;
use Honed\Chart\Style\Concerns\HasFontWeight;
use Honed\Chart\Style\Concerns\HasHeight;
use Honed\Chart\Style\Concerns\HasLineHeight;
use Honed\Chart\Style\Concerns\HasOverflow;
use Honed\Chart\Style\Concerns\HasShadowBlur;
use Honed\Chart\Style\Concerns\HasShadowColor;
use Honed\Chart\Style\Concerns\HasShadowOffset;
use Honed\Chart\Style\Concerns\HasWidth;

class TextStyle extends Chartable
{
    use HasBorderColor;
    use HasBorderType;
    use HasBorderWidth;
    use HasColor;
    use HasFontFamily;
    use HasFontFamily;
    use HasFontSize;
    use HasFontStyle;
    use HasFontWeight;
    use HasHeight;
    use HasLineHeight;
    use HasOverflow;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;
    use HasWidth;

    /**
     * Get the representation of the text style.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'color' => $this->getColor(),
            'fontStyle' => $this->getFontStyle(),
            'fontWeight' => $this->getFontWeight(),
            'fontFamily' => $this->getFontFamily(),
            'fontSize' => $this->getFontSize(),
            'lineHeight' => $this->getLineHeight(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'textBorderColor' => $this->getBorderColor(),
            'textBorderWidth' => $this->getBorderWidth(),
            'textBorderType' => $this->getBorderType(),
            'textShadowBlur' => $this->getShadowBlur(),
            'textShadowColor' => $this->getShadowColor(),
            'textShadowOffsetX' => $this->getShadowOffsetX(),
            'textShadowOffsetY' => $this->getShadowOffsetY(),
            'overflow' => $this->getOverflow(),
            // 'ellipsis' => $this->getEllipsis(),
        ];
    }
}
