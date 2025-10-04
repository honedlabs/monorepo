<?php

declare(strict_types=1);

namespace Honed\Infolist\Concerns;

use Honed\Infolist\Contracts\Formatter;
use Honed\Infolist\Formatters\DefaultFormatter;

/**
 * @template TValue
 * @template TReturn
 *
 * @phpstan-require-implements Formatter<TValue, TReturn>
 */
trait HasFormatter
{
    /**
     * The formatter for the entry.
     *
     * @var Formatter<TValue, TReturn>|null
     */
    protected $formatter;

    /**
     * Set the formatter.
     *
     * @param  class-string<Formatter<TValue, TReturn>>|Formatter<TValue, TReturn>  $formatter
     */
    public function formatter(string|Formatter $formatter): static
    {
        $this->formatter = is_string($formatter) ? resolve($formatter) : $formatter;

        return $this;
    }

    /**
     * Get the formatter.
     *
     * @return Formatter<TValue, TReturn>
     */
    public function getFormatter(): Formatter
    {
        return $this->formatter ??= new DefaultFormatter();
    }

    /**
     * Format the value.
     *
     * @param  TValue|null  $value
     * @return TReturn|null
     */
    public function format(mixed $value): mixed
    {
        return $this->getFormatter()->format($value);
    }
}
