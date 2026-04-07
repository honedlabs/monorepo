<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\AxisPointer\HasAxisPointerAnimation;
use Honed\Chart\Concerns\AxisPointer\HasAxisPointerType;
use Honed\Chart\Concerns\AxisPointer\HasShadowStyle;
use Honed\Chart\Concerns\AxisPointer\HasSnap;
use Honed\Chart\Concerns\AxisPointer\HasTriggerTooltip;
use Honed\Chart\Concerns\Components\HasCrossStyle;
use Honed\Chart\Concerns\Components\HasLineStyle;
use Honed\Chart\Concerns\Components\HasPointerLabel;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Proxies\HigherOrderAxisPointerLabel;
use Honed\Chart\Proxies\HigherOrderLineStyle;
use Honed\Chart\Proxies\HigherOrderShadowStyle;

/**
 * @property-read \Honed\Chart\Proxies\HigherOrderAxisPointerLabel<static> $label
 * @property-read \Honed\Chart\Proxies\HigherOrderLineStyle<static> $lineStyle
 * @property-read \Honed\Chart\Proxies\HigherOrderShadowStyle<static> $shadowStyle
 * @property-read \Honed\Chart\Proxies\HigherOrderLineStyle<static> $crossStyle
 */
class AxisPointer extends Chartable
{
    use HasAxisPointerAnimation;
    use HasAxisPointerType;
    use HasCrossStyle;
    use HasLineStyle;
    use HasPointerLabel;
    use HasShadowStyle;
    use HasSnap;
    use HasTriggerTooltip;
    use Proxyable;

    /**
     * Get a property of the axis pointer.
     * 
     * @param  non-empty-string  $name
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'label' => new HigherOrderAxisPointerLabel($this, $this->withAxisPointerLabel()),
            'lineStyle' => new HigherOrderLineStyle($this, $this->withLineStyle()),
            'shadowStyle' => new HigherOrderShadowStyle($this, $this->withAxisPointerShadowStyle()),
            'crossStyle' => new HigherOrderLineStyle($this, $this->withCrossStyle()),
            default => $this->defaultGet($name),
        };
    }

    /**
     * Get the array representation of the axis pointer.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'type' => $this->getAxisPointerType()?->value,
            'snap' => $this->getSnap(),
            'label' => $this->getAxisPointerLabel()?->toArray(),
            'animation' => $this->getPointerAnimation(),
            'animationDurationUpdate' => $this->getAnimationDurationUpdate(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
            'shadowStyle' => $this->getAxisPointerShadowStyle()?->toArray(),
            'crossStyle' => $this->getCrossStyle()?->toArray(),
            'triggerTooltip' => $this->getTriggerTooltip(),
        ];
    }
}
