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
     * @var TextStyle|null
     */
    protected $textStyle;

    /**
     * Set the text style.
     *
     * @param  TextStyle|(Closure(TextStyle):TextStyle)|null  $value
     * @return $this
     */
    public function textStyle(TextStyle|Closure|null $value = null): static
    {
        $this->textStyle = match (true) {
            is_null($value) => $this->withTextStyle(),
            $value instanceof Closure => $value($this->withTextStyle()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the text style.
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
