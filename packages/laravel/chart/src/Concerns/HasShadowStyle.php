<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Style\ShadowStyle;

trait HasShadowStyle
{
    /**
     * The shadow style.
     *
     * @var ShadowStyle|null
     */
    protected $shadowStyle;

    /**
     * Set the shadow style.
     *
     * @param  ShadowStyle|(Closure(ShadowStyle):ShadowStyle)|null  $value
     * @return $this
     */
    public function shadowStyle(ShadowStyle|Closure|null $value = null): static
    {
        $this->shadowStyle = match (true) {
            is_null($value) => $this->withShadowStyle(),
            $value instanceof Closure => $value($this->withShadowStyle()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the shadow style.
     */
    public function getShadowStyle(): ?ShadowStyle
    {
        return $this->shadowStyle;
    }

    /**
     * Create a new shadow style instance.
     */
    protected function withShadowStyle(): ShadowStyle
    {
        return $this->shadowStyle ??= ShadowStyle::make();
    }
}
