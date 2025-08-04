<?php

declare(strict_types=1);

namespace Honed\Chart\Title;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasItemGap;
use Honed\Chart\Concerns\HasSubtextStyle;
use Honed\Chart\Concerns\HasTextStyle;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Style\Concerns\HasBackgroundColor;
use Honed\Chart\Style\Concerns\HasBorderColor;
use Honed\Chart\Style\Concerns\HasBorderRadius;
use Honed\Chart\Style\Concerns\HasBorderWidth;
use Honed\Chart\Style\Concerns\HasBottom;
use Honed\Chart\Style\Concerns\HasLeft;
use Honed\Chart\Style\Concerns\HasPadding;
use Honed\Chart\Style\Concerns\HasRight;
use Honed\Chart\Style\Concerns\HasShadowBlur;
use Honed\Chart\Style\Concerns\HasShadowColor;
use Honed\Chart\Style\Concerns\HasShadowOffset;
use Honed\Chart\Style\Concerns\HasTop;
use Honed\Chart\Title\Concerns\HasSubtext;
use Honed\Chart\Title\Concerns\HasText;
use Honed\Core\Concerns\CanHaveUrl;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Title extends Primitive implements NullsAsUndefined
{
    use HasId;
    use CanBeShown;
    use CanHaveUrl;
    use HasText;
    use HasZAxis;
    use HasTextStyle;
    use HasLeft;
    use HasTop;
    use HasRight;
    use HasBottom;
    use HasBackgroundColor;
    use HasBorderColor;
    use HasBorderWidth;
    use HasBorderRadius;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;
    use HasItemGap;
    use HasPadding;
    use HasSubtextStyle;
    use HasSubtext;

    /**
     * Create a new title instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the title.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'text' => $this->getText(),
            'link' => $this->getUrl(),
            'target' => null,
            'textStyle' => $this->getTextStyle()?->toArray(),
            'subtext' => $this->getSubtext(),
            // 'sublink' => $this->getSublink(),
            // 'subtarget' => $this->getSubtarget(),
            'subtextStyle' => $this->getSubtextStyle()?->toArray(),
            // 'textAlign' => $this->getTextAlign(),
            // 'triggerEvent' => $this->getTriggerEvent(),
            'padding' => $this->getPadding(),
            'itemGap' => $this->getItemGap(),
            'zLevel' => $this->getZLevel(),
            'z' => $this->getZ(),
            'left' => $this->getLeft(),
            'top' => $this->getTop(),
            'right' => $this->getRight(),
            'bottom' => $this->getBottom(),
            'backgroundColor' => $this->getBackgroundColor(),
            'borderColor' => $this->getBorderColor(),
            'borderWidth' => $this->getBorderWidth(),
            'borderRadius' => $this->getBorderRadius(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
        ];
    }
}