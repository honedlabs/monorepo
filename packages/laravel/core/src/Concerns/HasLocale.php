<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasLocale
{
    /**
     * @var string|null
     */
    protected $locale = null;

    /**
     * Get or set the locale for the instance.
     * 
     * @param string|null $locale The locale to set, or null to retrieve the current locale.
     * @return string|null|$this The current locale when no argument is provided, or the instance when setting the locale.
     */
    public function locale($locale = null)
    {
        if (\is_null($locale)) {
            return $this->locale;
        }

        $this->locale = $locale;

        return $this;
    }

    /**
     * Determine if the instance has an locale set.
     * 
     * @return bool True if an locale is set, false otherwise.
     */
    public function hasLocale()
    {
        return ! \is_null($this->locale);
    }
}
