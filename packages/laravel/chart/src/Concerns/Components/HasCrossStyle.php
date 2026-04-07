<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\LineStyle;

trait HasCrossStyle
{
    /**
     * @var ?LineStyle
     */
    protected $crossStyleInstance;

    /**
     * Set the cross style.
     * 
     * @param  LineStyle|(Closure(LineStyle): LineStyle)|bool|null  $value
     * @return $this
     */
    public function crossStyle(LineStyle|Closure|bool|null $value = true): static
    {
        $this->crossStyleInstance = match (true) {
            $value => $this->withCrossStyle(),
            $value instanceof Closure => $value($this->withCrossStyle()),
            $value instanceof LineStyle => $value,
            default => null,
        };

        return $this;
    }

    /**
     * Get the cross style.
     */
    public function getCrossStyle(): ?LineStyle
    {
        return $this->crossStyleInstance;
    }

    /**
     * Create a new cross style instance.
     */
    protected function withCrossStyle(): LineStyle
    {
        return $this->crossStyleInstance ??= LineStyle::make();
    }
}
