<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Style\LineStyle;

trait HasLineStyle
{
    /**
     * The line style.
     * 
     * @var \Honed\Chart\Style\LineStyle|null
     */
    protected $lineStyle;

    /**
     * Set the line style.
     * 
     * @param \Honed\Chart\Style\LineStyle|(Closure(\Honed\Chart\Style\LineStyle):\Honed\Chart\Style\LineStyle)|null $value
     * @return $this
     */
    public function lineStyle(LineStyle|Closure|null $value = null): static
    {
        $this->lineStyle = match (true) {
            is_null($value) => $this->withLineStyle(),
            $value instanceof Closure => $value($this->withLineStyle()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the line style.
     * 
     * @return \Honed\Chart\Style\LineStyle|null
     */
    public function getLineStyle(): ?LineStyle
    {
        return $this->lineStyle;
    }

    /**
     * Create a new line style instance.
     */
    protected function withLineStyle(): LineStyle
    {
        return $this->lineStyle ??= LineStyle::make();
    }
}