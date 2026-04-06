<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Components\HasTextStyle;
use Honed\Chart\Tooltip\Concerns\HasTrigger;
use Illuminate\Support\Traits\ForwardsCalls;

class Tooltip extends Chartable
{
    use CanBeShown;
    use ForwardsCalls;
    use HasTextStyle;
    use HasTrigger;

    /**
     * Get the representation of the tooltip.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'trigger' => $this->getTrigger(),
            // 'showContent' => $this->
            // 'alwaysShowContent' =>
            // 'triggerOn' => $this->getTriggerOn(),
            // 'showDelay' => $this->getShowDelay(),
            // 'hideDelay' => $this->getHideDelay(),
            // 'enterable' => $this->isEnterable(),
            // 'confine' => $this->isConfined(),
            // 'appendToBody' => $this->isAppendedToBody(),
            // 'className' => $this->getClass(),
            // 'transitionDuration' => $this->getTransitionDuration(),
            // 'position',
            // 'backgroundColor' => $this->getBackgroundColor(),
            // 'borderColor' => $this->getBorderColor(),
            // 'borderWidth' => $this->getBorderWidth(),
            // 'padding' => $this->getPadding(),
            'textStyle' => $this->getTextStyle()?->toArray(),
            // 'order' => $this->getOrder(),
        ];
    }
}
