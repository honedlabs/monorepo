<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Style\TextStyle;

trait HasSubtextStyle
{
    /**
     * The subtext style.
     * 
     * @var \Honed\Chart\Style\TextStyle|null
     */
    protected $subtextStyle;

    /**
     * Set the subtext style.
     * 
     * @param \Honed\Chart\Style\TextStyle|(Closure(\Honed\Chart\Style\TextStyle):\Honed\Chart\Style\TextStyle)|null $value
     * @return $this
     */
    public function subtextStyle(TextStyle|Closure|null $value): static
    {
        $this->subtextStyle = match (true) {
            is_null($value) => $this->withSubtextStyle(),
            $value instanceof Closure => $value($this->withSubtextStyle()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the subtext style.
     * 
     * @return \Honed\Chart\Style\TextStyle|null
     */
    public function getSubtextStyle(): ?TextStyle
    {
        return $this->subtextStyle;
    }

    /**
     * Create a new subtext style instance.
     */
    protected function withSubtextStyle(): TextStyle
    {
        return $this->subtextStyle ??= TextStyle::make();
    }
}