<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

trait CanBeBoolean
{
    public const BOOLEAN = 'boolean';

    /**
     * The text to display when the value is true.
     */
    protected ?string $trueText = null;

    /**
     * The text to display when the value is false.
     */
    protected ?string $falseText = null;

    /**
     * Set the text to display when the value is true.
     *
     * @return $this
     */
    public function trueText(string $text): static
    {
        $this->trueText = $text;

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
    public function falseText(string $text): static
    {
        $this->falseText = $text;

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
     */
    protected function formatBoolean(mixed $value): ?string
    {
        return ((bool) $value) ? $this->getTrueText() : $this->getFalseText();
    }
}
