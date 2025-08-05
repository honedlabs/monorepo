<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasLineStyle;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class AxisLine extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use HasLineStyle;

    /**
     * Whether the X or Y axis lines on the other's origin position.
     * 
     * @var bool|null
     */
    protected $onZero;

    /**
     * When multiple axes exists, this option can be used to specify which axis.
     * 
     * @var int|null
     */
    protected $onZeroAxisIndex;

    /**
     * Create a new axis line.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Set whether the X or Y axis lines on the other's origin position.
     * 
     * @return $this
     */
    public function onZero(bool $value = true): static
    {
        $this->onZero = $value;

        return $this;
    }

    /**
     * Set whether the X or Y axis lines do not on the other's origin position.
     * 
     * @return $this
     */
    public function notOnZero(bool $value = true): static
    {
        return $this->onZero(! $value);
    }

    /**
     * Get whether the X or Y axis lines on the other's origin position.
     * 
     * @return false|null
     */
    public function isOnZero(): ?bool
    {
        return $this->onZero ? null : false;
    }

    /**
     * Get whether the X or Y axis lines do not on the other's origin position.
     */
    public function isNotOnZero(): bool
    {
        return ! $this->onZero;
    }

    /**
     * Get the array representation of the axis line.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'onZero' => $this->isOnZero(),
            // 'onZeroAxisIndex' => $this->getOnZeroAxisIndex(),
            // 'symbol' => $this->getSymbol(),
            // 'symbolSize' => $this->getSymbolSize(),
            // 'symbolOffset' => $this->getSymbolOffset(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
        ];
    }
}