<?php

declare(strict_types=1);

namespace Honed\Chart\AxisPointer;

use Honed\Core\Primitive;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasTextStyle;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Chart\Tooltip\Concerns\HasTrigger;
use Honed\Chart\AxisPointer\Concerns\CanBeSnapped;
use Honed\Chart\AxisPointer\Concerns\HasAxisPointerType;
use Honed\Chart\Concerns\HasLabel;
use Honed\Chart\Concerns\HasLineStyle;
use Honed\Chart\Concerns\HasShadowStyle;
use Honed\Chart\Style\Concerns\HasZ;

class AxisPointer extends Primitive implements NullsAsUndefined
{
    use HasId;
    use CanBeShown;
    use HasTrigger;
    use CanBeSnapped;
    use HasAxisPointerType;
    use HasLabel;
    use HasLineStyle;
    use HasTextStyle;
    use HasShadowStyle;
    use HasZ;

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
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'type' => $this->getType(),
            'snap' => $this->isSnapped(),
            'z' => $this->getZ(),
            'label' => $this->getLabel()?->toArray(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
            'shadowStyle' => $this->getShadowStyle()?->toArray(),
            // 'triggerEmphasis' => $this->isTriggerEmphasis(),
            // 'triggerTooltip' => $this->isTriggerTooltip(),
            // 'value',
            // 'status',
            // 'triggerOn' => $this->getTriggerOn(),
        ];
    }

}