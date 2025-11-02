<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait HasDateFormat
{
    /**
     * The format of the date.
     *
     * @var ?string
     */
    protected $format;

    /**
     * Set the format of the date.
     *
     * @return $this
     */
    public function format(?string $value): static
    {
        $this->format = $value;

        return $this;
    }

    /**
     * Get the format of the date.
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * Determine if the format is set.
     */
    public function hasFormat(): bool
    {
        return $this->getFormat() !== null;
    }

    /**
     * Determine if the format is not set.
     */
    public function missingFormat(): bool
    {
        return ! $this->hasFormat();
    }
}
