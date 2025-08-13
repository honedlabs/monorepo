<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Concerns;

use Honed\Chart\Enums\ColorBy;

trait HasColorBy
{
    /**
     * The policy to take color from.
     *
     * @var string|null
     */
    protected $colorBy;

    /**
     * Set the policy to take color from.
     *
     * @return $this
     */
    public function colorBy(string|ColorBy $value): static
    {
        $this->colorBy = is_string($value) ? $value : $value->value;

        return $this;
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

    /**
     * Get the policy to take color from.
     */
    public function getColorBy(): ?string
    {
        return $this->colorBy;
    }
}
