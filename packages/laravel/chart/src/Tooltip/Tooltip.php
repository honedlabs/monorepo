<?php

declare(strict_types=1);

namespace Honed\Chart\Tooltip;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasTextStyle;
use Honed\Chart\Style\Concerns\HasBackgroundColor;
use Honed\Chart\Style\Concerns\HasBorderColor;
use Honed\Chart\Style\Concerns\HasBorderWidth;
use Honed\Chart\Style\Concerns\HasPadding;
use Honed\Chart\Tooltip\Concerns\HasTrigger;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Tooltip extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use HasBackgroundColor;
    use HasBorderColor;
    use HasBorderWidth;
    use HasPadding;
    use HasTextStyle;
    use HasTrigger;
    // use HasOrder;

    /**
     * Create a new tooltip instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

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
            'backgroundColor' => $this->getBackgroundColor(),
            'borderColor' => $this->getBorderColor(),
            'borderWidth' => $this->getBorderWidth(),
            'padding' => $this->getPadding(),
            'textStyle' => $this->getTextStyle()?->toArray(),
            // 'order' => $this->getOrder(),
        ];
    }
}
