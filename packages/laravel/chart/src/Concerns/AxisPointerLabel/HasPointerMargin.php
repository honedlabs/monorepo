<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointerLabel;

trait HasPointerMargin
{
    /**
     * The margin around the axis pointer label.
     *
     * @var int|float|list<int|float>|null
     */
    protected $pointerMargin;

    /**
     * Set the margin around the axis pointer label.
     *
     * @param  int|float|list<int|float>|null  $value
     * @return $this
     */
    public function margin(int|float|array|null $value): static
    {
        $this->pointerMargin = $value;

        return $this;
    }

    /**
     * Get the margin around the axis pointer label.
     *
     * @return int|float|list<int|float>|null
     */
    public function getPointerMargin(): int|float|array|null
    {
        return $this->pointerMargin;
    }
}
