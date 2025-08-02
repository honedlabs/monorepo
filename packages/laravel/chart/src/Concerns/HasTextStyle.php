<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Style\TextStyle;

trait HasTextStyle
{
    /**
     * The text style.
     * 
     * @var \Honed\Chart\Style\TextStyle|null
     */
    protected $textStyle;

    /**
     * Set the text style.
     * 
     * @param \Honed\Chart\Style\TextStyle|(Closure(\Honed\Chart\Style\TextStyle):mixed)|null $textStyle
     * @return $this
     */
    public function textStyle(TextStyle|Closure|null $textStyle): static
    {
        $this->textStyle = $textStyle instanceof Closure ? $textStyle($this->withTextStyle()) : $textStyle;

        return $this;
    }

    /**
     * Get the text style.
     * 
     * @return \Honed\Chart\Style\TextStyle|null
     */
    public function getTextStyle(): ?TextStyle
    {
        return $this->textStyle;
    }

    /**
     * Create a new text style instance.
     */
    protected function withTextStyle(): TextStyle
    {
        return $this->textStyle ??= TextStyle::make();
    }
}