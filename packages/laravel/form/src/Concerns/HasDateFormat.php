<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Closure;

trait HasDateFormat
{
    /**
     * The format of the date.
     *
     * @var string|(Closure():string)|null
     */
    protected $format;

    /**
     * Set the format of the date.
     *
     * @param  string|(Closure():string)|null  $value
     * @return $this
     */
    public function format(string|Closure|null $value): static
    {
        $this->format = $value;

        return $this;
    }

    /**
     * Get the format of the date.
     */
    public function getFormat(): ?string
    {
        return $this->evaluate($this->format);
    }

    /**
     * Determine if the format is set.
     */
    public function hasFormat(): bool
    {
        return isset($this->format);
    }

    /**
     * Determine if the format is not set.
     */
    public function missingFormat(): bool
    {
        return ! $this->hasFormat();
    }
}
