<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

use Honed\Core\Formatters\Contracts\Formatter;

trait HasFormatter
{
    /**
     * @var \Honed\Core\Formatters\Contracts\Formatter|null
     */
    protected $formatter = null;

    public function setFormatter(Formatter $formatter): void
    {
        $this->formatter = $formatter;
    }

    public function getFormatter(): ?Formatter
    {
        return $this->formatter;
    }

    public function missingFormatter(): bool
    {
        return \is_null($this->formatter);
    }

    public function hasFormatter(): bool
    {
        return ! $this->missingFormatter();
    }

    // public function asBoolean()

    // public function asString()

    // public function asDate()

    // public function asArray()

    // public function asNumeric()

    // public function asCurrency()

        /**
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

