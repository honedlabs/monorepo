<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Facades\App;

trait HasLocale
{
    /**
     * @var string|null
     */
    protected $locale = null;

    /**
     * Set the locale, chainable.
     *
     * @return $this
     */
    public function locale(string $locale): static
    {
        $this->setLocale($locale);

        return $this;
    }

    /**
     * Set the locale quietly.
     */
    public function setLocale(?string $locale): void
    {
        if (\is_null($locale)) {
            return;
        }

        $this->locale = $locale;
    }

    /**
     * Get the locale.
     */
    public function getLocale(): string
    {
        return $this->locale ?? App::getLocale();
    }

    /**
     * Determine if the class has a locale.
     */
    public function hasLocale(): bool
    {
        return ! \is_null($this->locale);
    }
}
