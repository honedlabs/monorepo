<?php

declare(strict_types=1);

namespace Honed\Infolist\Concerns;

use Honed\Infolist\Contracts\Formatter;
use Honed\Infolist\Contracts\ScopedFormatter;
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
     * @param  class-string<Formatter<TValue, TReturn>>|Formatter<TValue, TReturn>|null  $formatter
     */
    public function formatter(string|Formatter|null $formatter): static
    {
        $this->formatter = $formatter instanceof Formatter
            ? $formatter
            : app($formatter);

        return $this;
    }

    /**
     * Get the formatter.
     *
     * @return Formatter<TValue, TReturn>
     */
    public function getFormatter(): Formatter
    {
        return $this->formatter ??= $this->defaultFormatter();
    }

    /**
     * Get a cloned copy of the formatter.
     *
     * @return Formatter<TValue, TReturn>
     */
    public function cloneFormatter(): Formatter
    {
        return clone $this->getFormatter();
    }

    /**
     * Format the value.
     *
     * @param  TValue  $value
     * @return TReturn
     */
    public function format(mixed $value): mixed
    {
        $formatter = $this instanceof ScopedFormatter
            ? $this->getScopedFormatter()
            : $this->getFormatter();

        return $formatter->format($value);
    }

    /**
     * Get a scoped formatter.
     *
     * @return Formatter<TValue, TReturn>
     */
    public function getScopedFormatter(): Formatter
    {
        // @phpstan-ignore-next-line method.notFound
        return $this->scopeFormatter($this->cloneFormatter());
    }

    /**
     * Get the default formatter.
     *
     * @return Formatter<TValue, TReturn>
     */
    public function defaultFormatter(): Formatter
    {
        return new DefaultFormatter();
    }
}
