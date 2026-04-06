<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\LineStyle;

trait HasLineStyle
{
    /**
     * The line style.
     *
     * @var ?LineStyle
     */
    protected $lineStyleInstance;

    /**
     * Set the line style.
     *
     * @param  LineStyle|(Closure(LineStyle):LineStyle)|bool|null  $value
     * @return $this
     */
    public function lineStyle(LineStyle|Closure|bool|null $value = true): static
    {
        $this->lineStyleInstance = match (true) {
            $value => $this->withLineStyle(),
            ! $value => null,
            $value instanceof Closure => $value($this->withLineStyle()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the line style.
     */
    public function getLineStyle(): ?LineStyle
    {
        return $this->lineStyleInstance;
    }

    /**
     * Create a new line style instance.
     */
    protected function withLineStyle(): LineStyle
    {
        return $this->lineStyleInstance ??= LineStyle::make();
    }
}
