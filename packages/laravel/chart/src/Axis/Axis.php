<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Chart\Axis\Concerns\CanAlignTicks;
use Honed\Chart\Axis\Concerns\CanBeInverted;
use Honed\Chart\Axis\Concerns\CanBeScaled;
use Honed\Chart\Axis\Concerns\HasAxisType;
use Honed\Chart\Axis\Concerns\HasBoundaryGap;
use Honed\Chart\Axis\Concerns\HasDimension;
use Honed\Chart\Axis\Concerns\HasGridIndex;
use Honed\Chart\Axis\Concerns\HasInterval;
use Honed\Chart\Axis\Concerns\HasLogBase;
use Honed\Chart\Axis\Concerns\HasMax;
use Honed\Chart\Axis\Concerns\HasMaxInterval;
use Honed\Chart\Axis\Concerns\HasMin;
use Honed\Chart\Axis\Concerns\HasMinInterval;
use Honed\Chart\Axis\Concerns\HasSplitNumber;
use Honed\Chart\Axis\Concerns\HasStartValue;
use Honed\Chart\Concerns\Animatable;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\CanBeSilent;
use Honed\Chart\Concerns\Extractable;
use Honed\Chart\Concerns\HasAxisPointer;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasTooltip;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Contracts\Resolvable;
use Honed\Chart\Support\Concerns\HasOffset;
use Honed\Chart\Support\Concerns\HasPosition;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Axis extends Primitive implements NullsAsUndefined, Resolvable
{
    use Animatable;
    use CanAlignTicks;
    use CanBeInverted;
    use CanBeScaled;
    use CanBeShown;
    use CanBeSilent;
    use Extractable;
    use HasAxisPointer;
    use HasAxisType;
    use HasBoundaryGap;
    use HasBoundaryGap;
    use HasDimension;
    use HasGridIndex;
    use HasId;
    use HasInterval;
    use HasLogBase;
    use HasMax;
    use HasMaxInterval;
    use HasMin;
    use HasMinInterval;
    use HasOffset;
    use HasPosition;
    use HasSplitNumber;
    use HasStartValue;
    use HasTooltip;
    use HasZAxis;

    /**
     * Create a new axis instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Resolve the axis with the given data.
     */
    public function resolve(mixed $data): void
    {
        $this->define();

        $this->data($this->extract($data));
    }

    /**
     * Get the representation of the axis.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        $this->define();

        return [
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'gridIndex' => $this->getGridIndex(),
            'alignTicks' => $this->hasAlignedTicks(),
            'position' => $this->getPosition(),
            'offset' => $this->getOffset(),
            'type' => $this->getType(),
            // 'name' => null,
            // 'nameLocation' => null,
            // 'nameTextStyle' => null,
            // 'nameGap' => $this->getNameGap(),
            // 'nameRotate' => $this->getNameRotate(),
            // 'nameTruncate' => $this->getTruncate()?->toArray(),
            'inverse' => $this->isInverted(),
            'boundaryGap' => $this->getBoundaryGap(),
            'min' => $this->getMin(),
            'max' => $this->getMax(),
            'scale' => $this->isScaled() ?: null,
            'splitNumber' => $this->getSplitNumber(),
            'minInterval' => $this->getMinInterval(),
            'maxInterval' => $this->getMaxInterval(),
            'interval' => $this->getInterval(),
            'logBase' => $this->getLogBase(),
            'startValue' => $this->getStartValue(),
            'silent' => $this->isSilent() ?: null,
            // 'triggerEvent' => $this->isTriggerable(),
            // 'axisLine',
            // 'axisTick',
            // 'minorTick',
            // 'axisLabel'
            // 'splitLine'
            // 'minorSplitLine'
            // 'splitArea'
            'data' => $this->getData(),
            'axisPointer' => $this->getAxisPointer()?->toArray(),
            'tooltip' => $this->getTooltip()?->toArray(),
            ...$this->getAnimationParameters(),
            'zLevel' => $this->getZLevel(),
            'z' => $this->getZ(),
        ];
    }
}
