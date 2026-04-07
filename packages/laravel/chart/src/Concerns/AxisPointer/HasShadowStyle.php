<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointer;

use Closure;
use Honed\Chart\ShadowStyle;

trait HasShadowStyle
{
    /**
     * @var ?ShadowStyle
     */
    protected $axisPointerShadowStyle;

    /**
     * @param  ShadowStyle|(Closure(ShadowStyle): ShadowStyle)|bool|null  $value
     * @return $this
     */
    public function shadowStyle(ShadowStyle|Closure|bool|null $value = true): static
    {
        $this->axisPointerShadowStyle = match (true) {
            $value instanceof Closure => $value($this->withAxisPointerShadowStyle()),
            $value instanceof ShadowStyle => $value,
            $value === true => $this->withAxisPointerShadowStyle(),
            default => null,
        };

        return $this;
    }

    public function getAxisPointerShadowStyle(): ?ShadowStyle
    {
        return $this->axisPointerShadowStyle;
    }

    protected function withAxisPointerShadowStyle(): ShadowStyle
    {
        return $this->axisPointerShadowStyle ??= ShadowStyle::make();
    }
}
