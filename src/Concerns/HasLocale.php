<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Facades\App;

trait HasLocale
{
    /**
     * @var string|(\Closure():string)|null
     */
    protected $locale = null;

    /**
     * Set the locale, chainable.
     *
     * @param string|(\Closure():string) $locale
     * @return $this
     */
    public function locale(string|\Closure $locale): static
    {
        $this->setLocale($locale);

        return $this;
    }

    /**
     * Set the locale quietly.
     *
     * @param string|(\Closure():string)|null $locale
     */
    public function setLocale(string|\Closure|null $locale): void
    {
        if (\is_null($locale)) {
            return;
        }

        $this->locale = $locale;
    }

    /**
     * Get the locale.
     * 
     * @param mixed $parameter
     * @return string
     */
    public function getLocale($parameter = null): string
    {
        return value($this->locale, $parameter) ?? App::getLocale();
    }

    /**
     * Determine if the class does not have a locale.
     * 
     * @return bool
     */
    public function missingLocale(): bool
    {
        return \is_null($this->locale);
    }

    /**
     * Determine if the class has a locale.
     *
     * @return bool
     */
    public function hasLocale(): bool
    {
        return ! $this->missingLocale();
    }
}
