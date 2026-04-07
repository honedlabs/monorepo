<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Style\HasBorderColor;
use Honed\Chart\Concerns\Style\HasBorderType;
use Honed\Chart\Concerns\Style\HasBorderWidth;
use Honed\Chart\Concerns\Style\HasColor;
use Honed\Chart\Concerns\Style\HasFontFamily;
use Honed\Chart\Concerns\Style\HasFontSize;
use Honed\Chart\Concerns\Style\HasFontStyle;
use Honed\Chart\Concerns\Style\HasFontWeight;
use Honed\Chart\Concerns\Style\HasHeight;
use Honed\Chart\Concerns\Style\HasLineHeight;
use Honed\Chart\Concerns\Style\HasOverflow;
use Honed\Chart\Concerns\Style\HasShadowBlur;
use Honed\Chart\Concerns\Style\HasShadowColor;
use Honed\Chart\Concerns\Style\HasShadowOffset;
use Honed\Chart\Concerns\Style\HasWidth;

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
