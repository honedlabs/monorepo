<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Components\HasTextStyle;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Concerns\Style\HasBackgroundColor;
use Honed\Chart\Concerns\Style\HasBorderColor;
use Honed\Chart\Concerns\Style\HasBorderWidth;
use Honed\Chart\Concerns\Style\HasBottom;
use Honed\Chart\Concerns\Style\HasLeft;
use Honed\Chart\Concerns\Style\HasPadding;
use Honed\Chart\Concerns\Style\HasRight;
use Honed\Chart\Concerns\Style\HasTop;
use Honed\Chart\Concerns\Style\HasZ;
use Honed\Chart\Concerns\Style\HasZLevel;
use Honed\Chart\Concerns\Tooltip\HasTrigger;
use Honed\Chart\Proxies\HigherOrderTextStyle;
use Illuminate\Support\Traits\ForwardsCalls;

class Tooltip extends Chartable
{
    use CanBeShown;
    use ForwardsCalls;
    use HasBackgroundColor;
    use HasBorderColor;
    use HasBorderWidth;
    use HasBottom;
    use HasLeft;
    use HasPadding;
    use HasRight;
    use HasTextStyle;
    use HasTop;
    use HasTrigger;
    use HasZ;
    use HasZLevel;
    use Proxyable;

    /**
     * Get a property of the tooltip.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'textStyle' => new HigherOrderTextStyle($this, $this->withTextStyle()),
            default => $this->defaultGet($name),
        };
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
            'trigger' => $this->getTrigger()?->value,
            'zlevel' => $this->getZLevel(),
            'z' => $this->getZ(),
            'left' => $this->getLeft(),
            'top' => $this->getTop(),
            'right' => $this->getRight(),
            'bottom' => $this->getBottom(),
            'backgroundColor' => $this->getBackgroundColor(),
            'borderColor' => $this->getBorderColor(),
            'borderWidth' => $this->getBorderWidth(),
            'padding' => $this->getPadding(),
            'textStyle' => $this->getTextStyle()?->toArray(),
        ];
    }
}
