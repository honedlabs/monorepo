<?php

declare(strict_types=1);

namespace Honed\List\Entries\Concerns;

trait CanBeBoolean
{
    /**
     * The text to display when the value is true.
     * 
     * @var string|null
     */
    protected ?string $trueText = null;

    /**
     * The text to display when the value is false.
     * 
     * @var string|null
     */
    protected ?string $falseText = null;

    /**
     * Set the text to display when the value is true.
     * 
     * @param  string  $text
     * @return $this
     */
    public function trueText(string $text): static
    {
        $this->trueText = $text;

        return $this;
    }

    /**
     * Get the text to display when the value is true.
     * 
     * @return string|null
     */
    public function getTrueText(): ?string
    {
        return $this->trueText;
    }

    /**
     * Determine if a true text is set.
     * 
     * @return bool
     */
    public function hasTrueText(): bool
    {
        return isset($this->trueText);
    }

    /**
     * Set the text to display when the value is false.
     * 
     * @param  string  $text
     * @return $this
     */
    public function falseText(string $text): static
    {
        $this->falseText = $text;

        return $this;
    }

    /**
     * Get the text to display when the value is false.
     * 
     * @return string|null
     */
    public function getFalseText(): ?string
    {
        return $this->falseText;
    }

    /**
     * Determine if a false text is set.
     * 
     * @return bool
     */
    public function hasFalseText(): bool
    {
        return isset($this->falseText);
    }

    /**
     * Format the value as a boolean.
     * 
     * @param  mixed  $value
     * @return bool|string|null
     */
    protected function formatBoolean(mixed $value): bool|string|null
    {
        return (bool) $value ? $this->getTrueText() : $this->getFalseText();
    }
}