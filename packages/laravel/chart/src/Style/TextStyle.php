<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Style\Concerns\HasFontFamily;
use Honed\Chart\Style\Concerns\HasFontSize;
use Honed\Chart\Style\Concerns\HasFontWeight;
use Honed\Chart\Style\Concerns\HasLineHeight;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Style\Concerns\HasHeight;
use Honed\Chart\Style\Concerns\HasWidth;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class TextStyle extends Primitive implements NullsAsUndefined
{
    use HasColor;
    use HasFontFamily;
    use HasFontWeight;
    use HasFontFamily;
    use HasFontSize;
    use HasLineHeight;
    use HasWidth;
    use HasHeight;

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
            // 'textBorderColor' => $this->getTextBorderColor(),
            // 'textBorderWidth' => $this->getTextBorderWidth(),
            // 'textBorderType' => $this->getTextBorderType(),
            // 'textShadowBlur' => $this->getTextShadowBlur(),
            // 'textShadowColor' => $this->getTextShadowColor(),
            // 'textShadowOffsetX' => $this->getTextShadowOffsetX(),
            // 'textShadowOffsetY' => $this->getTextShadowOffsetY(),
            // 'overflow' => $this->getOverflow(),
            // 'ellipsis' => $this->getEllipsis(),
        ];
    }
}