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
     * Set the shadow style for the axis pointer.
     *
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

    /**
     * Shadow style for the shadow pointer (if configured).
     */
    public function getAxisPointerShadowStyle(): ?ShadowStyle
    {
        return $this->axisPointerShadowStyle;
    }

    /**
     * Resolve or create the shadow style instance.
     */
    protected function withAxisPointerShadowStyle(): ShadowStyle
    {
        return $this->axisPointerShadowStyle ??= ShadowStyle::make();
    }
}
