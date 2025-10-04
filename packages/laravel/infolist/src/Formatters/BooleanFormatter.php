<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Contracts\Formatter;

/**
 * @implements Formatter<mixed, string>
 */
class BooleanFormatter implements Formatter
{
    /**
     * The text to display when the value is true.
     *
     * @var string|null
     */
    protected $trueText;

    /**
     * The text to display when the value is false.
     *
     * @var string|null
     */
    protected $falseText;

    /**
     * Set the text to display when the value is true.
     *
     * @return $this
     */
    public function trueText(string $value): static
    {
        $this->trueText = $value;

        return $this;
    }

    /**
     * Get the text to display when the value is true.
     */
    public function getTrueText(): ?string
    {
        return $this->trueText;
    }

    /**
     * Set the text to display when the value is false.
     *
     * @return $this
     */
    public function falseText(string $value): static
    {
        $this->falseText = $value;

        return $this;
    }

    /**
     * Get the text to display when the value is false.
     */
    public function getFalseText(): ?string
    {
        return $this->falseText;
    }

    /**
     * Format the value as a boolean.
     *
     * @return string|null
     */
    public function format(mixed $value): mixed
    {
        return ((bool) $value) ? $this->getTrueText() : $this->getFalseText();
    }
}
