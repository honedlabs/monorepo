<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class TextStyle extends Primitive implements NullsAsUndefined
{
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
            'textBorderColor' => $this->getTextBorderColor(),
            'textBorderWidth' => $this->getTextBorderWidth(),
            'textBorderType' => $this->getTextBorderType(),
            'textShadowBlur' => $this->getTextShadowBlur(),
            'textShadowColor' => $this->getTextShadowColor(),
            'textShadowOffsetX' => $this->getTextShadowOffsetX(),
            'textShadowOffsetY' => $this->getTextShadowOffsetY(),
            'overflow' => $this->getOverflow(),
            'ellipsis' => $this->getEllipsis(),
        ];
    }
}