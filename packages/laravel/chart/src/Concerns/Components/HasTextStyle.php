<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\TextStyle;

trait HasTextStyle
{
    /**
     * The text style.
     *
     * @var ?TextStyle
     */
    protected $textStyleInstance;

    /**
     * Set the text style.
     *
     * @param  TextStyle|(Closure(TextStyle):TextStyle)|bool|null  $value
     * @return $this
     */
    public function textStyle(TextStyle|Closure|bool|null $value = true): static
    {
        $this->textStyleInstance = match (true) {
            $value => $this->withTextStyle(),
            $value instanceof Closure => $value($this->withTextStyle()),
            $value instanceof TextStyle => $value,
            default => null,
        };

        return $this;
    }

    /**
     * Get the text style.
     */
    public function getTextStyle(): ?TextStyle
    {
        return $this->textStyleInstance;
    }

    /**
     * Create a new text style instance.
     */
    protected function withTextStyle(): TextStyle
    {
        return $this->textStyleInstance ??= TextStyle::make();
    }
}
