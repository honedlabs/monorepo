<?php

declare(strict_types=1);

namespace Honed\Chart\Title;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasTextStyle;
use Honed\Chart\Concerns\HasZAxis;
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

    protected function representation(): array
    {
        return [
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'text' => $this->getText(),
            'link' => $this->getUrl(),
            'target' => null,
            'textStyle' => $this->getTextStyle()?->toArray(),
            // 'subtext' => $this->getSubtext(),
            // 'sublink' => $this->getSublink(),
            // 'subtarget' => $this->getSubtarget(),
            // 'subtextStyle' => $this->getSubtextStyle()?->toArray(),
            // 'textAlign' => $this->getTextAlign(),
            // 'triggerEvent' => $this->getTriggerEvent(),
            // 'padding' => $this->getPadding(),
            // 'itemGap' => $this->getItemGap(),
            'zLevel' => $this->getZLevel(),
            'z' => $this->getZ(),
            // 'left' => $this->getLeft(),
            // 'top' => $this->getTop(),
            // 'right' => $this->getRight(),
            // 'bottom' => $this->getBottom(),
            // 'backgroundColor' => $this->getBackgroundColor(),
            // 'borderColor' => $this->getBorderColor(),
            // 'borderWidth' => $this->getBorderWidth(),
            // 'borderRadius' => $this->getBorderRadius(),
            // 'borderWidth' => $this->getBorderWidth(),
            // 'shadowBlur' => $this->getShadowBlur(),
            // 'shadowColor' => $this->getShadowColor(),
            // 'shadowOffsetX' => $this->getShadowOffsetX(),
            // 'shadowOffsetY' => $this->getShadowOffsetY(),
        ];
    }
}