<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Chart\Axis\Concerns\CanAlignTicks;
use Honed\Chart\Axis\Concerns\CanBeScaled;
use Honed\Chart\Axis\Concerns\HasAxisType;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Animatable;
use Honed\Chart\Concerns\HasId;
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

    public static function make(): static
    {
        return resolve(static::class);
    }


    /**
     * Get the representation of the axis.
     */
    protected function representation(): array
    {
        $this->define();

        return [
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'type' => $this->getType(),
            'z' => $this->getZ(),
            'zLevel' => $this->getZLevel(),
            ...$this->getAnimationParameters(),
        ];
    }
}