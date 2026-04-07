<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointerLabel;

trait HasPointerMargin
{
    /**
     * @var int|float|list<int|float>|null
     */
    protected $pointerMargin;

    /**
     * @param  int|float|list<int|float>|null  $value
     * @return $this
     */
    public function margin(int|float|array|null $value): static
    {
        $this->pointerMargin = $value;

        return $this;
    }

    public function getPointerMargin(): int|float|array|null
    {
        return $this->pointerMargin;
    }
}
