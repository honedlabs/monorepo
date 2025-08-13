<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Concerns\Animatable;
use Honed\Chart\Concerns\Extractable;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Contracts\Resolvable;
use Honed\Chart\Series\Concerns\CanBeClipped;
use Honed\Chart\Series\Concerns\HasChartType;
use Honed\Chart\Series\Concerns\RefersToAxis;
use Honed\Chart\Style\Concerns\HasCursor;
use Honed\Core\Concerns\HasName;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

abstract class Series extends Primitive implements NullsAsUndefined, Resolvable
{
    use Animatable;
    use CanBeClipped;
    use Extractable;
    use HasChartType;
    use HasCursor;
    use HasId;
    use HasName;
    use HasZAxis;
    use RefersToAxis;

    /**
     * Create a new series instance.
     */
    public static function make(?string $name = null): static
    {
        return resolve(static::class)
            ->when($name, fn (self $series, string $name) => $series->name($name));
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
            'name' => $this->name,
            'data' => $this->getData(),
            'cursor' => $this->getCursor(),
            'clip' => $this->isClipped() ? null : false,
            // ...$this->getZAxisParameters(),
            ...$this->getAnimationParameters(),
        ];
    }
}
