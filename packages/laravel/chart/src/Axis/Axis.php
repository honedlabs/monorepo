<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Chart\Axis\Concerns\CanAlignTicks;
use Honed\Chart\Axis\Concerns\CanBeScaled;
use Honed\Chart\Axis\Concerns\HasAxisType;
use Honed\Chart\Axis\Concerns\HasDimension;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Animatable;
use Honed\Chart\Concerns\Extractable;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasTooltip;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Enums\AxisType;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Axis extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use CanBeScaled;
    use CanAlignTicks;
    use HasId;
    use Animatable;
    use HasAxisType;
    use HasZAxis;
    use Extractable;
    use HasTooltip;
    use HasDimension;

    public const X = 'x';

    public const Y = 'y';

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
            // 'gridIndex' => $this->getGridIndex(),
            'alignTicks' => $this->hasAlignedTicks(),
            // 'position' => $this->getPosition(),
            // 'offset' => $this->getOffset(),
            'type' => $this->getType(),
            // 'name' => null,
            // 'nameLocation' => null,
            // 'nameTextStyle' => null,
            // 'boundaryGap' => null,
            // 'min' => null,
            // 'max' => null,
            'scale' => $this->isScaled(),
            // 'splitNumber' => $this->getSplitNumber(),
            // 'minInterval' => $this->getMinInterval(),
            // 'maxInterval' => $this->getMaxInterval(),
            // 'interval' => $this->getInterval(),
            // 'logBase' => $this->getLogBase(),
            // 'axisPointer' => $this->getAxisPointer()?->toArray(),
            'tooltip' => $this->getTooltip()?->toArray(),
            ...$this->getAnimationParameters(),
            ...$this->getZAxisParameters(),
        ];
    }
}