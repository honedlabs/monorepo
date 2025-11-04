<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters\Support;

use Honed\Infolist\Contracts\Formatter;
use Illuminate\Support\Facades\App;

/**
 * @template TValue
 * @template TReturn
 *
 * @implements Formatter<TValue, TReturn>
 */
abstract class LocalisedFormatter implements Formatter
{
    /**
     * The locale to use for formatting.
     *
     * @var ?string
     */
    protected $locale;

    /**
     * Set the locale to use for formatting.
     *
     * @return $this
     */
    public function locale(?string $value): static
    {
        $this->locale = $value;

        return $this;
    }

    /**
     * Get the locale to use for formatting.
     */
    public function getLocale(): string
    {
        return $this->locale ?? App::getLocale();
    }
}
