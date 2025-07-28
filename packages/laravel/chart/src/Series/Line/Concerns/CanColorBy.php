<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line\Concerns;

use Honed\Chart\Enums\ColorBy;

trait CanColorBy
{
    /**
     * The policy to take color from.
     * 
     * @var \Honed\Chart\Enums\ColorBy|null
     */
    protected $colorBy;

    /**
     * Set the policy to take color from.
     * 
     * @return $this
     */
    public function colorBy(ColorBy|string $value): static
    {
        if (! $value instanceof ColorBy) {
            $value = ColorBy::from($value);
        }

        $this->colorBy = $value;

        return $this;
    }

    /**
     * Get the policy to take color from.
     */
    public function getColorBy(): ?string
    {
        return $this->colorBy?->value;
    }

    /**
     * Set the policy to take color from to be series, which will assign the colors
     * in the palette according to series, such that all data in the same series will have the same color.
     * 
     * @return $this
     */
    public function colorBySeries(): static
    {
        return $this->colorBy(ColorBy::Series);
    }

    /**
     * Set the policy to take color from to be data, which will assign the colors
     * in the palette according to data items, such that each data item will have a different color.
     * 
     * @return $this
     */
    public function colorByData(): static
    {
        return $this->colorBy(ColorBy::Data);
    }    
}