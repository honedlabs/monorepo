<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasPlaceholder
{
    /**
     * @var string|null
     */
    protected $placeholder = null;

    /**
     * Get or set the placeholder for the instance.
     * 
     * @param string|null $placeholder The placeholder to set, or null to retrieve the current placeholder.
     * @return string|null|$this The current placeholder when no argument is provided, or the instance when setting the placeholder.
     */
    public function placeholder($placeholder = null)
    {
        if (\is_null($placeholder)) {
            return $this->placeholder;
        }

        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Determine if the instance has an placeholder set.
     * 
     * @return bool True if an placeholder is set, false otherwise.
     */
    public function hasPlaceholder()
    {
        return ! \is_null($this->placeholder);
    }
}
