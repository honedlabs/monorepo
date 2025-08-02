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
     * @param \Honed\Chart\Style\TextStyle|(Closure(\Honed\Chart\Style\TextStyle):mixed)|null $value
     * @return $this
     */
    public function subtextStyle(TextStyle|Closure|null $value): static
    {
        $this->subtextStyle = $value instanceof Closure ? $value($this->withSubtextStyle()) : $value;

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