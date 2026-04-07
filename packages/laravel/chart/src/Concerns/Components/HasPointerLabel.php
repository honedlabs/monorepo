<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\AxisPointerLabel;

trait HasPointerLabel
{
    /**
     * @var ?AxisPointerLabel
     */
    protected $axisPointerLabelInstance;

    /**
     * @param  AxisPointerLabel|(Closure(AxisPointerLabel): AxisPointerLabel)|bool|null  $value
     * @return $this
     */
    public function label(AxisPointerLabel|Closure|bool|null $value = true): static
    {
        $this->axisPointerLabelInstance = match (true) {
            $value => $this->withAxisPointerLabel(),
            $value instanceof Closure => $value($this->withAxisPointerLabel()),
            $value instanceof AxisPointerLabel => $value,
            default => null,
        };

        return $this;
    }

    public function getAxisPointerLabel(): ?AxisPointerLabel
    {
        return $this->axisPointerLabelInstance;
    }

    protected function withAxisPointerLabel(): AxisPointerLabel
    {
        return $this->axisPointerLabelInstance ??= AxisPointerLabel::make();
    }
}
