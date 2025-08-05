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
     * @var \Honed\Chart\Style\ShadowStyle|null
     */
    protected $shadowStyle;

    /**
     * Set the shadow style.
     * 
     * @param \Honed\Chart\Style\ShadowStyle|(Closure(\Honed\Chart\Style\ShadowStyle):\Honed\Chart\Style\ShadowStyle)|null $value
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
     * 
     * @return \Honed\Chart\Style\ShadowStyle|null
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