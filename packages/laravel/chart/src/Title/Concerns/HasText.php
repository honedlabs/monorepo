<?php

declare(strict_types=1);

namespace Honed\Chart\Title\Concerns;

/**
 * @internal
 */
trait HasText
{
    /**
     * The main title text.
     *
     * @var string|null
     */
    protected $text;

    /**
     * Set the main title text.
     *
     * @return $this
     */
    public function text(?string $value): static
    {
        $this->text = $value;

        return $this;
    }

    /**
     * Get the main title text.
     */
    public function getText(): ?string
    {
        return $this->text;
    }
}
