<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

trait CanBeBoolean
{
    public const BOOLEAN = 'boolean';

    /**
     * The text to display when the value is true.
     *
     * @var string|null
     */
    protected $trueText = null;

    /**
     * The text to display when the value is false.
     *
     * @var string|null
     */
    protected $falseText = null;

    /**
     * Set the text to display when the value is true.
     *
     * @param  string  $text
     * @return $this
     */
    public function trueText($text)
    {
        $this->trueText = $text;

        return $this;
    }

    /**
     * Get the text to display when the value is true.
     *
     * @return string|null
     */
    public function getTrueText()
    {
        return $this->trueText;
    }

    /**
     * Set the text to display when the value is false.
     *
     * @param  string  $text
     * @return $this
     */
    public function falseText($text)
    {
        $this->falseText = $text;

        return $this;
    }

    /**
     * Get the text to display when the value is false.
     *
     * @return string|null
     */
    public function getFalseText()
    {
        return $this->falseText;
    }

    /**
     * Format the value as a boolean.
     *
     * @param  mixed  $value
     * @return string|null
     */
    protected function formatBoolean($value)
    {
        return ((bool) $value) ? $this->getTrueText() : $this->getFalseText();
    }
}
