<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait HasText
{
    /**
     * The text to display.
     *
     * @var string|null
     */
    protected $text;

    /**
     * Set the text to display.
     *
     * @return $this
     */
    public function text(string $value): static
    {
        $this->text = $value;

        return $this;
    }

    /**
     * Get the text to display.
     */
    public function getText(): ?string
    {
        return $this->text;
    }
}
