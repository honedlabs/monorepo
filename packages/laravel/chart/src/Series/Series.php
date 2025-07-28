<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Concerns\Animatable;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Concerns\HasChartType;
use Honed\Chart\Series\Concerns\RefersToAxis;
use Honed\Core\Concerns\HasName;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Series extends Primitive implements NullsAsUndefined
{
    use HasId;
    use HasChartType;
    use RefersToAxis;
    use Animatable;
    use HasZAxis;

    /**
     * Create a new series instance.
     */
    public static function make(?string $name = null): static
    {
        return resolve(static::class)
            ->name($name);
    }

    /**
     * Get the representation of the series.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'type' => $this->getType(),
            'id' => $this->getId(),
            'name' => null,
            'data' => [],
            'z' => $this->getZ(),
            'zLevel' => $this->getZLevel(),
            ...$this->getAnimationParameters(),
        ];
    }
}