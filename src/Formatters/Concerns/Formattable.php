<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

use Honed\Core\Formatters\StringFormatter;
use Honed\Core\Formatters\BooleanFormatter;
use Honed\Core\Formatters\Contracts\Formatter;

trait HasFormatter
{
    /**
     * @var \Honed\Core\Formatters\Contracts\Formatter|null
     */
    protected $formatter = null;

    /**
     * Set the formatter, chainable.
     *
     * @param \Honed\Core\Formatters\Contracts\Formatter $formatter
     * @return $this
     */
    public function formatter(Formatter $formatter): static
    {
        $this->setFormatter($formatter);

        return $this;
    }

    /**
     * Set the formatter quietly.
     *
     * @param \Honed\Core\Formatters\Contracts\Formatter|null $formatter
     */
    public function setFormatter(Formatter|null $formatter): void
    {
        if (\is_null($formatter)) {
            return;
        }

        $this->formatter = $formatter;
    }

    /**
     * Get the formatter.
     * 
     * @return \Honed\Core\Formatters\Contracts\Formatter|null
     */
    public function getFormatter(): ?Formatter
    {
        return $this->formatter;
    }

    /**
     * Determine if the class does not have a formatter.
     * 
     * @return bool
     */
    public function missingFormatter(): bool
    {
        return \is_null($this->formatter);
    }

    /**
     * Determine if the class has a formatter.
     * 
     * @return bool
     */
    public function hasFormatter(): bool
    {
        return ! $this->missingFormatter();
    }

    /**
     * Set the class to use a boolean formatter.
     * 
     * @param string|\Closure|null $truthLabel
     * @param string|\Closure|null $falseLabel
     * @return $this
     */
    public function asBoolean(string|\Closure|null $truthLabel = null, string|\Closure|null $falseLabel = null): bool
    {
        return $this->formatter(BooleanFormatter::make($truthLabel, $falseLabel));
    }

    /**
     * Set the class to use a string formatter.
     * 
     * @return $this
     */
    public function asString(): static
    {
        return $this->formatter(StringFormatter::make());
    }

    // public function asDate()

    // public function asNumeric()

    // public function asCurrency()

    /**
     * Apply the formatter to the given value.
     * 
     * @template T
     * @param T $value
     * @return T|mixed
     */
    public function format(mixed $value)
    {
        if ($this->missingFormatter()) {
            return $value;
        }

        return $this->formatter->format($value);
    }
}

