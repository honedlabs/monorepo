<?php

declare(strict_types=1);

namespace Honed\Chart\Title;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasItemGap;
use Honed\Chart\Concerns\HasSubtextStyle;
use Honed\Chart\Concerns\HasTextStyle;
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
use Honed\Chart\Style\Concerns\HasZ;
use Honed\Chart\Style\Concerns\HasZLevel;
use Honed\Chart\Support\Concerns\CanBeAligned;
use Honed\Chart\Support\Concerns\CanBeVerticallyAligned;
use Honed\Chart\Support\Concerns\Triggerable;
use Honed\Chart\Title\Concerns\HasLink;
use Honed\Chart\Title\Concerns\HasSublink;
use Honed\Chart\Title\Concerns\HasSubtarget;
use Honed\Chart\Title\Concerns\HasSubtext;
use Honed\Chart\Title\Concerns\HasTarget;
use Honed\Chart\Title\Concerns\HasText;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Title extends Primitive implements NullsAsUndefined
{
    use CanBeAligned;
    use CanBeShown;
    use CanBeVerticallyAligned;
    use HasBackgroundColor;
    use HasBorderColor;
    use HasBorderRadius;
    use HasBorderWidth;
    use HasBottom;
    use HasId;
    use HasItemGap;
    use HasLeft;
    use HasLink;
    use HasPadding;
    use HasRight;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;
    use HasSublink;
    use HasSubtarget;
    use HasSubtext;
    use HasSubtextStyle;
    use HasTarget;
    use HasText;
    use HasTextStyle;
    use HasTop;
    use HasZ;
    use HasZLevel;
    use Triggerable;

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
            'link' => $this->getLink(),
            'target' => $this->getTarget(),
            'textStyle' => $this->getTextStyle()?->toArray(),
            'subtext' => $this->getSubtext(),
            'sublink' => $this->getSublink(),
            'subtarget' => $this->getSubtarget(),
            'subtextStyle' => $this->getSubtextStyle()?->toArray(),
            'textAlign' => $this->getAlign(),
            'textVerticalAlign' => $this->getVerticalAlign(),
            'triggerEvent' => $this->isTriggerable() ?: null,
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
