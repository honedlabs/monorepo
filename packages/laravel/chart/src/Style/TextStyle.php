<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Style\Concerns\HasBorderColor;
use Honed\Chart\Style\Concerns\HasBorderType;
use Honed\Chart\Style\Concerns\HasBorderWidth;
use Honed\Chart\Style\Concerns\HasColor;
use Honed\Chart\Style\Concerns\HasFontFamily;
use Honed\Chart\Style\Concerns\HasFontSize;
use Honed\Chart\Style\Concerns\HasFontStyle;
use Honed\Chart\Style\Concerns\HasFontWeight;
use Honed\Chart\Style\Concerns\HasLineHeight;
use Honed\Chart\Style\Concerns\HasHeight;
use Honed\Chart\Style\Concerns\HasOverflow;
use Honed\Chart\Style\Concerns\HasShadowBlur;
use Honed\Chart\Style\Concerns\HasShadowColor;
use Honed\Chart\Style\Concerns\HasShadowOffset;
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
    use HasBorderColor;
    use HasBorderWidth;
    use HasBorderType;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;
    use HasOverflow;
    use HasFontStyle;

    /**
     * Create a new text style instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

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