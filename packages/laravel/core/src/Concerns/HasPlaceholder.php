<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasPlaceholder
{
    /**
     * @var string|null
     */
    protected $placeholder;

    /**
     * Set the placeholder for the instance.
     *
     * @param  string|null  $placeholder
     * @return $this
     */
    public function placeholder($placeholder)
    {
        if (! \is_null($placeholder)) {
            $this->placeholder = $placeholder;
        }

        return $this;
    }

    /**
     * Get the placeholder for the instance.
     *
     * @return string|null
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Determine if the instance has an placeholder set.
     *
     * @return bool
     */
    public function hasPlaceholder()
    {
        return ! \is_null($this->placeholder);
    }
}
