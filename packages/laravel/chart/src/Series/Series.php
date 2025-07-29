<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Concerns\Animatable;
use Honed\Chart\Concerns\Extractable;
use Honed\Chart\Concerns\HasData;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Contracts\Resolvable;
use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Concerns\HasChartType;
use Honed\Chart\Series\Concerns\RefersToAxis;
use Honed\Core\Concerns\HasName;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

abstract class Series extends Primitive implements NullsAsUndefined, Resolvable
{
    use HasId;
    use HasChartType;
    use RefersToAxis;
    use Animatable;
    use HasZAxis;
    use Extractable;

    /**
     * Create a new series instance.
     */
    public static function make(?string $name = null): static
    {
        return resolve(static::class)
            ->name($name);
    }

    /**
     * Resolve the series with the given data.
     */
    public function resolve(mixed $data): void
    {
        $this->define();

        $this->data($this->extract($data));
    }
    /**
     * Get the representation of the series.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        $this->define();

        return [
            'type' => $this->getType(),
            'id' => $this->getId(),
            // 'name' => null,
            'data' => $this->getData(),
            ...$this->getZAxisParameters(),
            ...$this->getAnimationParameters(),
        ];
    }
}